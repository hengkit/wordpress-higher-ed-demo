// Old version of Ember - hide deprecations.
Ember.deprecate = function() {};
Ember.warn = function(i) {};

// Init application
App = Ember.Application.create();
App.env = "";
var maxWidth = 1400;

// Directory above webroot, please use trailing slash
var install_dir = window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')) + "/";

var _marketing = {
  edgeserver: [
    "Pantheon's Edge",
    "The edge has a built-in, ultra-fast cache that's automatically enabled for every site. It improves page load times for our customers and helps sites to cruise through viral traffic spikes without breaking a sweat."
  ],
  appserver: [
    "Application Container",
    "The essence of a runtime container is a highly tuned PHP-FPM worker and its connections to the outside world. Incoming requests come via an nginx web server which handles requests for static assets, and passes dynamic requests to PHP."
  ],
  dbserver: [
    "Database Server",
    "The Database Service uses MariaDB and a container architecture similar to the Runtime Matrix to provision DBs and perform workflow operations. Instead of scaling via load-balancing, the DB layer can provide redundancy and horizontal scalability by supporting a self-healing replication topology, which is managed automatically."
  ],
  slavedbserver: [
    "Failover Database Server(Replica)",
    "The Database Service uses MariaDB and a container architecture similar to the Runtime Matrix to provision DBs and perform workflow operations. Instead of scaling via load-balancing, the DB layer can provide redundancy and horizontal scalability by supporting a self-healing replication topology, which is managed automatically."
  ],
  cacheserver: [
    "Redis",
    "Available for your applications to use in order to speed up processing."
  ],
  fileserver: [
    "Pantheon File System",
    "Our PFS (Pantheon File System) is a breakthrough in network-attached storage. It is backed by a self-healing elastic cluster architecture, and its advanced FUSE client rivals local on-disk filesystems for performance, thanks to a thoroughly modern leveldb caching layer."
  ],
  newrelic: [
    "New Relic APM",
    "It’s about gaining actionable, real-time business insights from the billions of metrics your software is producing, including user click streams, mobile activity, end user experiences and transactions.<img class='img-fluid' src='img/newrelic-graph.png' />"
  ],
  indexserver: [
    "Apache Solr™",
    "The popular, blazing fast open source enterprise search platform from the Apache Lucene project. Its major features include powerful full-text search, hit highlighting, faceted search, near real-time indexing, dynamic clustering, database integration, rich document (e.g., Word, PDF) handling, and geospatial search."
  ],
  codeserver: [
    "Git Version Control",
    "Git is a free and open source distributed version control system designed to handle everything from small to very large projects with speed and efficiency."
  ]
};

// Object of environments.
var environments = {
  basic: {
    label: "Basic",
    traffic: "Up to 125K/month",
    containers: 1
  },
  performancesmall: {
    label: "Performance (Small)",
    traffic: "Up to 125K/month",
    containers: 1
  },
  performancemedium: {
    label: "Performance (Medium)",
    traffic: "Up to 250K/month",
    containers: 2
  },
  performancelarge: {
    label: "Performance (Large)",
    traffic: "Up to 750K/month",
    containers: 3
  },
  performancexl: {
    label: "Performance (Extra Large)",
    traffic: "Up to 1.5M/month",
    containers: 6
  },
  elite: {
    label: "Elite",
    traffic: "Unlimited",
    containers: 8
  },
  elitemax: {
    label: "Elite (Traffic Spike)",
    traffic: "Unlimited++",
    containers: 10
  },
  multiplesites: {
    label: "",
    traffic: "Up to 125K/month",
    containers: 0
  },
  disaster: {
    label: "",
    traffic: "Up to 125K/month",
    containers: 0
  }
};

// Add to Global scope for other uses.
window.environments = environments;

// Static function for getting data.
function getAppTarget(env) {
  if (['dev', 'test', 'live'].indexOf(env) == -1) {
    return false;
  }
  return environments.hasOwnProperty(env);
}

// Only one route for this application
App.Router.map(function() {
  this.resource("diagram", { path: "diagram/:env_id" });
});

App.IndexRoute = Ember.Route.extend({
  beforeModel: function() {
    this.transitionTo("diagram");
  }
});

App.DiagramRoute = Ember.Route.extend({
  model: function(params) {
    App.env = params.env_id;

    return new Ember.RSVP.Promise(function(resolve) {
      
      // Set base API call.
      var target = install_dir + "index.php";

      // Local testing data or static data
      if (location.hostname == "localhost" || location.hostname == "127.0.0.1" || location.port !== "") {
        target = "/data/servers.json";
        if (App.env == "") {
          App.env = "performancelarge";
        }
      }
      // Load the hard coded site plans
      target = getAppTarget(App.env) ? "data/" + App.env + ".json" : target;

      // Load the actual site based on the environment selected
      $.get(
        target + "?env=" + params.env_id,
        function(d) {
          // Debug servers
          window.debugServers = d;

          // Create new site instance.
          if (!App.mySite) {
            App.mySite = new Site();
          }
          App.mySite.load(d.servers);
          resolve(App.mySite);

          // Clear polling.
          if (App.poller) {
            clearInterval(App.poller);
          }

          // Poll the API using index.php every 2 seconds
          App.poller = window.setInterval(function() {
            $.get(
              target + "?env=" + params.env_id,
              function(d) {
                App.mySite.load(d.servers);
              },
              "json"
            );
          }, 2000);
        },
        "json"
      );
    });
  },
  setupController: function(controller, model) {
    controller.set("model", model);
    controller.set("graph", false);
  }
});

var infobarViewInstance, infobarContentViewInstance;

App.NavView = Ember.View.extend({
  templateName: "nav",
  didInsertElement: function() {

    var self = this;
    var $diagramContainer = $("#diagramContainer");

    // Dropdown menus
    var $navbar = $(".navbar");
    var $navLinks = $("a[data-env]", $navbar);
    var $siteTiers = $("#site-tiers span", $navbar);

    // Append traffic icons to incoming traffic region.
    self.appendTrafficIcon = function(id) {
      id = id || "#thecloud";
      var user_image = '<div class="circleIcon"><img src="img/incoming-traffic.svg" /></div>';
      $(user_image).appendTo(id);
    };

    // Clear the area.
    self.resetCloud = function (clearGraph) {
      clearGraph = clearGraph || false;

      $("#thecloud").empty();
      
      // Remove SVG
      if (clearGraph == true) {
        $("#graph-container").empty();
      }

      $diagramContainer.removeClass("multiplesites-container").removeClass("disaster-container");
  
    }
    
    // Reusable update function
    self.updateText = function() {
      $navLinks.removeClass('active');
      var env = window.environments[App.env];

      console.log(App.env);
      console.log(env);

      // Defaults
      var traffic = "Up to 125K/month";
      var defaultText = $siteTiers.text();
      var region = "us-central1"
      
      // Check if we have a bogus value.
      if (env !== undefined) {
        traffic = env.traffic;
        defaultText = env.label;
        if (env.endpoint_zone !== undefined) {
          region = env.endpoint_zone;
        }
      }

      if (App.env == 'disaster' || App.env == 'multiplesites' ) {
        $diagramContainer.removeClass(
          "multiplesites-container",
          "disaster-container"
        );
        $diagramContainer.addClass(App.env + "-container");
      } else {
        $diagramContainer.removeClass(
          "multiplesites-container",
          "disaster-container"
        );
      }

      // Update text in incoming traffic / region
      var targetLink = 'a[data-env="' + App.env + '"]';
      $(targetLink, $navbar).addClass('active');
      $('#internet h5.subtitle').text(traffic);
      $('#diagramContainer a.zone').text(region);
      
      // Switch name of environment in drop down.
      $siteTiers.text(defaultText);
    }

    // On any link click, adjust link attributes
    $navLinks.on('click', (e) => {
      $navLinks.removeClass("active");
      $(this).addClass("active");

      // Get environment
      var env = $(this).data('env');
  
      // Clean up.
      self.resetCloud();

      // Based on class, adds X users or update class.
      switch (env) {
        case "multiplesites":
          self.resetCloud(true);
          $diagramContainer.addClass("multiplesites-container");
          self.appendTrafficIcon();
          break;

        case "disaster":
          self.resetCloud(true);
          $diagramContainer.addClass("disaster-container");
          self.appendTrafficIcon();
          break;

        default:
          self.resetCloud();
          var containers = 1;
          // Check if container numbers are available.
          if (window.environments[env] !== undefined && window.environments[env].containers !== undefined) {
            containers = window.environments[env].containers;
          }
          // Add N number of traffic icons.
          for (i = 0; i < containers; i++) {
            self.appendTrafficIcon();
          }
          break;
      }
    });

    // Run initial text updates
    self.updateText();

    // Update nav on hash change
    $(window).on('hashchange', function() {
      self.updateText();
    });
  }
});

App.InfobarView = Ember.View.extend({
  templateName: "infobarContainer",
  didInsertElement: function() {
    var self = this;
    infobarViewInstance = self;
  },
  open: function() {
    var self = this;
    $("#infobarContainer")
      .addClass("emerge")
      .removeClass("hidden");
    $("#ember248").addClass("emerge");
  },
  close: function() {
    var self = this;
    $("#infobarContainer")
      .removeClass("emerge")
      .addClass("hidden");
    $("#ember248").removeClass("emerge");
  }
});

App.InfobarContentView = Ember.View.extend({
  templateName: "infobarContent",
  didInsertElement: function() {
    var self = this;
    infobarContentViewInstance = self;
    self.set("controller.title", "");
    self.set("controller.text", "");

    if (self.get("controller.node")) {
      self.nodeChange();
    }
  },
  nodeChange: function() {
    var self = this;
    node = self.get("controller.node");
    if (node) {
      self.set("controller.title", _marketing[node.type][0]);
      self.set("controller.text", _marketing[node.type][1]);
      self.set("controller.icon", "img/" + node.type + ".svg");
      $("#infobarContainer")
        .removeClass()
        .addClass(node.type);
      var icon = "img/" + node.type + ".svg";
      $(".infobarContent")
        .find(".headerIconWrapper")
        .css("background-image", "url(" + icon + ")");
      infobarViewInstance.open();
    } else {
      infobarViewInstance.close();
    }
  }.observes("controller.node")
});

App.DiagramView = Ember.View.extend({
  templateName: "diagram",
  didInsertElement: function() {
    var self = this;
    var graph = self.get("controller.graph");
    var mySite = App.mySite; //self.get('controller.model');
    var elementId = "#graph-container";

    // Set dimension of graphcontainer.
    var graphWidth = Math.min($("body").width(), maxWidth) - $("#infobarContainer").width();
    var graphHeight = 550; //$("body").height();

    // Create height/width of canvas container
    $(elementId).width(graphWidth).height(graphHeight);
      
    $("#infobarContainer").height($("body").height());

    if (!graph) {
      mySite.registerEvent("server.add", function(e) {
        self.drawServer(e.server);
        self.drawAllLinks();
      });

      mySite.registerEvent("server.delete", function(e) {
        self.undrawServer(e.server);
      });

      graph = new myGraph(elementId);
      graph.registerEvent("node.selected", function(e) {
        infobarContentViewInstance.set("controller.node", e.node);
      });
      graph.registerEvent("node.unselected", function(e) {
        if (infobarViewInstance.get("controller.node") == e.node) {
          infobarContentViewInstance.set("controller.node", false);
        }
      });
      self.set("controller.graph", graph);
      self.draw();
    }
  },
  draw: function() {
    var self = this;
    var graph = self.get("controller.graph");
    var mySite = App.mySite; //self.get('controller.model');
    var instances = mySite.get([]);
    $.each(instances, function(i, e) {
      self.drawServer(e);
    });
    self.drawAllLinks();
  },
  undrawServer: function(server) {
    var self = this;
    var graph = self.get("controller.graph");
    graph.removeNode(server.id);
  },
  drawServer: function(server) {
    var self = this;
    var graph = self.get("controller.graph");
    graph.addNode(server);
  },
  drawAllLinks: function() {
    var self = this;
    var mySite = App.mySite; //self.get('controller.model');
    var instances = mySite.get([]);
    $.each(instances, function(i, e) {
      self.drawLinks(e);
    });
  },
  drawLinks: function(server) {
    var self = this;
    var graph = self.get("controller.graph");
    $.each(server.links, function(i, e) {
      graph.addLink(server.id, e);
    });
  }
});
