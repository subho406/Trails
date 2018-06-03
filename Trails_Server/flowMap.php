
<?php
    /*
    if($_POST["flowMap"])
    {
        $flowMap = $_POST["flowMap"];
    }*/

    $flowMap = "test";
    $servername = "localhost";
    $username = "root";
    $password = "test123";
    $dbName = "Trails";

    $conn = new mysqli($servername, $username, $password, $dbName);
    if ($conn->connect_error)
    {
        die("Connection failed: ".$conn->connect_error);
    }

    $sql = "SELECT graph FROM FlowMap WHERE name='$flowMap' ";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    $flowData = $row['graph'];
    
    echo "
    <html>
    <head>

        <script type='text/javascript' src = 'vis.js'></script>
        <link href='vis.css' rel='stylesheet' type='text/css' />

        <style type='text/css'>
        #mynetwork {
            width: 1080px;
            height: 720px;
            border: 1px solid #444444;
            background-color: #222222;
            margin-left:auto;
            margin-right:auto;  
        }
    </style>

</head>
<body>

    <div id='mynetwork'></div>

    <script type='text/javascript'>
        // provide data in the DOT language
        var DOTstring = '$flowData';
        var parsedData = vis.network.convertDot(DOTstring);

      //   var container = document.getElementById('mynetwork');

      //   var data = {
      //     nodes: parsedData.nodes,
      //     edges: parsedData.edges
      // }

      // var options = parsedData.options;

      //   // you can extend the options like a normal JSON variable:
      // options.nodes = {
      //     color: 'grey'
      // }

      //   // create a network
      // var network = new vis.Network(container, data, options);

      // create a network
        var container = document.getElementById('mynetwork');

        var data = {
          nodes: parsedData.nodes,
          edges: parsedData.edges
      }

      var options = {
        nodes: {
            shape: 'dot',
            size: 20,
            color: '#ff4081',
            font: {
                size: 25,
                color: '#ffffff'
            },
            borderWidth: 3,
            shadow: true
        },

        edges: {
            width: 3,
            color: '#ff4081',
            shadow: true
        }, 

        physics: {
            forceAtlas2Based: {
                gravitationalConstant: -30,
                centralGravity: 0.005,
                springLength: 250,
                springConstant: 0.18
            },
            maxVelocity: 150,
            solver: 'forceAtlas2Based',
            timestep: 0.35,
            stabilization: {iterations: 150}
        }
    };
    var network = new vis.Network(container, data, options);

</script>

</body>
</html>

"

    /*echo "
    <script type='text/javascript'>

        // create an array with nodes
        var nodes = new vis.DataSet([
            {id: 1, label: '$node1'},
            {id: 2, label: '$node2'},
            {id: 3, label: '$node3'},
            {id: 4, label: '$node4'},
            {id: 5, label: '$node5'}
        ]);

        // create an array with edges
        var edges = new vis.DataSet([
            {from: 1, to: 3},
            {from: 1, to: 2},
            {from: 2, to: 4},
            {from: 2, to: 5},
            {from: 2, to: 3}
        ]);

        // create a network
        var container = document.getElementById('mynetwork');

        // provide the data in the vis format
        var data = {
            nodes: nodes,
            edges: edges
        };
        var options = {};

        // initialize your network!
        var network = new vis.Network(container, data, options);
    </script>
    "*/
    ?>
