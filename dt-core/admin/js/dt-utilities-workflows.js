jQuery(function ($) {

  /*** Globals ***/
  const NODE_TYPE_START = 'start';
  const NODE_TYPE_CONDITION = 'condition';
  const NODE_TYPE_ACTION = 'action';
  const NODE_TYPE_CONNECTION = 'connection';
  /*** Globals ***/

  /*** Event Listeners ***/
  $(document).on('change', '#workflows_management_section_select', function () {
    handle_workflow_manage_select();
  });

  $(document).on('click', '#workflows_management_section_new_but', function () {
    handle_new_workflow_request();
  });

  /*** Event Listeners ***/

  /*** Event Listeners - Header Functions ***/
  function handle_workflow_manage_select() {
  }

  function handle_new_workflow_request() {

    // Reset workflow design views
    $('#workflows_properties_section_div').fadeOut('slow');
    $('#workflows_design_section_div').fadeOut('slow', function () {

      // Create staging area
      let stage = new Konva.Stage({
        container: 'workflows_design_section_canvas',
        width: 600,
        height: 500
      });

      // Create default layer
      let layer = new Konva.Layer();

      // Create start node and assign to default layer
      layer.add(create_node(NODE_TYPE_START, stage.width() / 2, stage.height() / 2, stage, layer));

      // Add default layer to the stage
      stage.add(layer);

      // Draw the image
      layer.draw();

      // Handle stage events
      stage.on('contextmenu', function (e) {
        // prevent default behavior
        e.evt.preventDefault();
      });

      // Display new workflow canvas
      $('#workflows_design_section_div').fadeIn('fast');
    });
  }

  /*** Event Listeners - Header Functions ***/

  /*** Helper Functions ***/
  function create_node(type, x, y, stage, layer) {
    let id = Date.now();
    let fill = '';
    let label = '';

    switch (type) {
      case NODE_TYPE_START:
        fill = '#00D2FF';
        label = '[ ' + NODE_TYPE_START + ' ]';
        break;
      case NODE_TYPE_CONDITION:
        fill = '#ffd500';
        label = '[ ' + NODE_TYPE_CONDITION + ' ]';
        break;
      case NODE_TYPE_ACTION:
        fill = '#8ac93e';
        label = '[ ' + NODE_TYPE_ACTION + ' ]';
        break;
    }

    let node = new Konva.Shape({
      id: id,
      x: x,
      y: y,
      width: 50,
      height: 50,
      fill: fill,
      stroke: '#000000',
      strokeWidth: 4,
      draggable: true,
      label: label,
      radius: 15,
      sceneFunc: function (context, shape) {
        // Start drawing point
        context.beginPath();

        // Draw main node circle
        context.arc(shape.getAttr('width') / 2, shape.getAttr('height') / 2, shape.getAttr('radius'), 0, 360, false);

        // Draw text label
        let label_width = context.measureText(shape.getAttr('label')).width;
        context.fillText(shape.getAttr('label'), (shape.getAttr('width') / 2) - (label_width / 2), 0, shape.getAttr('width'));

        // (!) Konva specific method, it is very important
        // it will apply are required styles
        context.fillStrokeShape(shape);
      },
      dt_meta: {
        id: id,
        type: type,
        connections: []
      }
    });

    // Add event listeners
    on_event_mouseenter(node, stage);
    on_event_mouseleave(node, stage);
    on_event_dblclick(node, stage, layer);
    on_event_dragmove(node);
    on_event_click(node);

    return node;
  }

  function create_node_connection(from_node, to_node) {

    let id = Date.now();
    let line = new Konva.Arrow({
      id: id,
      points: create_node_connection_points(from_node, to_node),
      stroke: '#000000',
      strokeWidth: 2,
      lineCap: 'round',
      lineJoin: 'round',
      dt_meta: {
        id: id,
        type: NODE_TYPE_CONNECTION,
        from_node: from_node,
        to_node: to_node
      }
    });

    // Update node's dt meta data to also include new line!!!
    from_node.attrs.dt_meta.connections.push(line);
    to_node.attrs.dt_meta.connections.push(line);

    return line;
  }

  function create_node_connection_points(from_node, to_node) {
    let x1 = from_node.x() + (from_node.width() / 2);
    let y1 = from_node.y() + (from_node.height() / 2);
    let x2 = to_node.x() + (to_node.width() / 2);
    let y2 = to_node.y() + (to_node.height() / 2);

    return [x1, y1, x2, y2];
  }

  function display_node_properties(node) {
    $('#workflows_properties_section_div').fadeOut('slow', function () {

      // Determine node properties view to be displayed
      if (node) {
        switch (node.getAttr('dt_meta').type) {
          case NODE_TYPE_START:
            display_node_properties_start(node);
            break;
          case NODE_TYPE_CONDITION:
            display_node_properties_condition(node);
            break;
          case NODE_TYPE_ACTION:
            display_node_properties_action(node);
            break;
        }
      }
    });
  }

  function display_node_properties_start(node) {

    $('#workflows_properties_section_display_area').html($('#workflows_props_node_start').html());

    let start = new DtUtilitiesWorkflowsNodeStart($);
    start.say_hello();

    // Display node properties
    $('#workflows_properties_section_div').fadeIn('fast');
  }

  function display_node_properties_condition(node) {

    $('#workflows_properties_section_display_area').html($('#workflows_props_node_condition').html());


    // Display node properties
    $('#workflows_properties_section_div').fadeIn('fast');
  }

  function display_node_properties_action(node) {

    $('#workflows_properties_section_display_area').html($('#workflows_props_node_action').html());


    // Display node properties
    $('#workflows_properties_section_div').fadeIn('fast');
  }

  function on_event_mouseenter(node, stage) {
    node.on('mouseenter', function () {
      stage.container().style.cursor = 'pointer';
      node.setAttr('stroke', '#808080');
    });
  }

  function on_event_mouseleave(node, stage) {
    node.on('mouseleave', function () {
      stage.container().style.cursor = 'default';
      node.setAttr('stroke', '#000000');
    });
  }

  function on_event_dblclick(node, stage, layer) {
    node.on('dblclick dbltap', function () {

      let new_node = null;

      // New nodes to be created based on parent node type
      switch (node.getAttr('dt_meta').type) {
        case NODE_TYPE_START:
          new_node = create_node(NODE_TYPE_CONDITION, stage.getPointerPosition().x + 20, stage.getPointerPosition().y + 20, stage, layer);
          break;
        case NODE_TYPE_CONDITION:
          new_node = create_node(NODE_TYPE_ACTION, stage.getPointerPosition().x + 20, stage.getPointerPosition().y + 20, stage, layer);
          break;
        case NODE_TYPE_ACTION:
          // Action nodes do not spawn any other node types! End of the line! :)
          break;
      }

      // Proceed if we have a new node type
      if (new_node) {
        layer.add(new_node);
        layer.add(create_node_connection(node, new_node));
      }
    });
  }

  function on_event_dragmove(node) {
    node.on('dragmove', function () {
      //console.log(node.getAttr('dt_meta'));

      // Adjust any assigned connections
      if (node.getAttr('dt_meta').connections) {
        node.getAttr('dt_meta').connections.forEach(function (line, idx) {

          // Determine which side of the connector the node currently resides
          if (line.getAttr('dt_meta').from_node === node) {
            let to_node = line.getAttr('dt_meta').to_node;
            line.points(create_node_connection_points(node, to_node));

          } else if (line.getAttr('dt_meta').to_node === node) {
            let from_node = line.getAttr('dt_meta').from_node;
            line.points(create_node_connection_points(from_node, node));
          }
        });
      }
    });
  }

  function on_event_click(node) {
    node.on('click', function () {
      display_node_properties(node);
    });
  }

  /*** Helper Functions ***/

});
