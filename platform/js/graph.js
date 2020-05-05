function myGraph(el) {
    var self = this;

    self._events = {
        'node.selected'  :[],
        'node.unselected':[]
    }

    this.registerEvent = function(event, cb) {
        self._events[event].push(cb);
    }

    this._triggerEvent = function(event, target) {
        var e = {
            "name": event,
            "node": target
        };
        var listeners = self._events[event];
        $.each(listeners, function(i, cb) {
            cb(e);
        });
    }

    // Add and remove elements on the graph object
    this.addNode = function (node) {
        if (node.type == "edgeserver") {
            node.fixed = true;
            node.x = w/2;
            node.y = 50;
        }
        else if (node.type == "newrelic") {
            node.fixed = true;
            node.x=100;
            node.y=100;
        }
        else if (node.type == "codeserver") {
            node.fixed = true;
            node.x=100;
            node.y=225;
        }
        nodes.push(node);
        update();
    }

    // Remove node
    this.removeNode = function (id) {
        var i = 0;
        var n = findNode(id);
        while (i < links.length) {
            if ((links[i]['source'] == n)||(links[i]['target'] == n)) {
                links.splice(i,1);
            }
            else{
                i++;
            }
        }
        nodes.splice(findNodeIndex(id),1);
        update();
    }

    // Add node
    this.addLink = function (source, target) {

        if (findNode(source) && findNode(target)) {
            links.push({"source":findNode(source),"target":findNode(target)});
            update();
        }
    }

    /**
     * Find node with ID.
     * @param int id 
     */
    var findNode = function(id) {
        var toReturn = false;
        
        // Search through nodes for matchin ID.
        nodes.forEach((obj, i) => {
            if (obj.id == id) {
                toReturn = obj;
            }
        });

        return toReturn;
    }

    var findNodeIndex = function(id) {
        for (var i in nodes) {if (nodes[i]["id"] === id) return i};
    }

    // Set up the D3 visualisation in the specified element
    var w = $(el).innerWidth(), // Canvas width
        h = $(el).innerHeight(), // Canvas height
        r = 44; // Circle radius

    var vis = this.vis = d3.select(el).append("svg:svg")
        .attr("width", w)
        .attr("height", h)

    var linkGroup = vis.insert("g").attr("class", "linkGroup");
    var nodeGroup = vis.insert("g").attr("class", "nodeGroup");

    // Remember the node that is selected.
    var selectedNode = false;

    var force = d3.layout.force()
        .gravity(0.5)
        .friction(.75)
        .linkStrength(function(d) {
            if (d.target.type == "newrelic" || d.target.type == "codeserver") {
                return 0;
            }
            return 1;
        })
        .distance(function(d) {
            if (d.target.type == "codeserver" || d.target.type == "newrelic" || d.source.type == "codeserver" || d.source.type == "newrelic") {
                // console.log("d.target", d.target);
                return w/2;
            }
            if (d.source.links.length > 5 || d.target.type == "appserver") {
                return 50;
            }
            return 50;
        })//Could be a function
        .charge(function(d) {
            if (d.type == "appserver") {
                return -20000;
            }
            else if (d.type=="newrelic" || d.type=="codeserver") {
                return 0;
            }
            return -20000;
        })//Could be a function
        .size([w, h]);

    var nodes = force.nodes(),
        links = force.links();

    vis.on("click", function() {
        if (d3.event.defaultPrevented) return;
        if (selectedNode) {
            self._triggerEvent("node.unselected",selectedNode);
            selectedNode = false;
            activate();
        }
        d3.event.stopPropagation();
    });
    var activate;
    var update = function() {

        // Draw the nodes
        var node = nodeGroup.selectAll("g.node")
            .data(nodes, function(d) { 
                return d.id;
            })
            .on("click", function(d) {
                if (d3.event.defaultPrevented) return; // ignore drag
                // console.log("node clicked!");
                nodeGroup.selectAll("g.node")
                    .attr("stroke", "#EFD01B")
                    .attr("background", "#313945")
                    .attr("fill", "#313945")
                    .attr("stroke-width", 0);
                
                if (selectedNode.id == d.id) {
                    // Unselect if selected node is already selected, duh!
                    // console.log("Unselecting");
                    selectedNode = false;
                    self._triggerEvent("node.unselected",d);
                } else {
                    // console.log("Selecting");
                    selectedNode = d;
                    // d3.select(this).attr("stroke", "#EFD01B");
                    d3.select(this).attr("stroke-width", 4);
                    // d3.select(this).attr("background", "#00A9E0");
                    // d3.select(this).attr("fill", "#00A9E0");
                    self._triggerEvent("node.selected", d);
                }

                activate();
                d3.event.stopPropagation();
            });

        var nodeEnter = node.enter().insert("g")
            .attr("class", "node")

        nodeEnter.append("circle")
            .attr("class", "bgCircle")
            .attr("r", r)

        nodeEnter.append("circle")
            .attr("class", function(d) { return "server "+d.type; })
            .attr("r", r)

        nodeEnter.append("image")
            .attr("xlink:href", function(d) { return "img/" + d.type + ".svg"; })
            .attr("class", "icon")
            .attr("x", -25).attr("y", -25)
            .attr("width", 50).attr("height", 50)

        node.exit().remove();


        // Draw the links
        var link = linkGroup.selectAll("line.link")
            .data(links, function(d) { return d.source.id + "-" + d.target.id; });

        link.enter().insert("line")
            .attr("class", function(l) {
                classes = ["link"];
                if (l.target.type == "newrelic" || l.target.type=="codeserver") {
                    classes.push("dashed");
                }
                return classes.join(" ");
            });

        link.exit().remove();


        // Activate Links and Nodes based on node selection - called be event handlerss
        activate = function() {
            // Highlight pertinent links
            // Sorry about the verbosity of this... I guess I am too tired to get this right without typing it out.
            var targetsOrSources = [];
            link.classed("active",function(d) {
                var active = false;
                if (d.target.id == selectedNode.id) {active = true; }
                if (d.source.id == selectedNode.id) {active = true; }
                if (active) {
                    if (d.target.id != selectedNode.id) {targetsOrSources.push(d.target); }
                    if (d.source.id != selectedNode.id) {targetsOrSources.push(d.source); }
                }
                return active;
            });
            node.classed("inactive",function(n) {
                //No selection, bail.
                if (!selectedNode) {return false;}
                if (targetsOrSources.indexOf(n) > -1) {return false; }
                if (n.id == selectedNode.id) {return false; }
                return true;
            });
        }

        // Updating on ticks
        force.on("tick", function(e) {
            node.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
            node.attr("cx", function(d) { return d.x = Math.max(r, Math.min(w - r, d.x)); })
                .attr("cy", function(d) { return d.y = Math.max(r, Math.min(h - r, d.y)); });

            nodes.forEach(function(d, i) {
              if (d.type == "appserver") {d.y = 50;}
                else if (d.type == "dbserver" || d.type == "fileserver" || d.type == "cacheserver" || d.type == "indexserver") {d.y = 200;}
                else if (d.type == "slavedbserver") {d.y = 300;}
            });

            var k = 20 * e.alpha;

            link.attr("x1", function(d) { return d.source.x; })
                .attr("y1", function(d) { return d.source.y; })
                .attr("x2", function(d) { return d.target.x; })
                .attr("y2", function(d) { return d.target.y; });
        });

        // Restart the force layout.
        force.start();
    }

    // Make it all go
    update();
}
