class DtUtilitiesWorkflowsNodeStart {
  $ = null;

  constructor($) {
    this.$ = $;
  }

  say_hello() {
    console.log("HELLO FROM ME....!");
    console.log(this.$('#workflows_props_node_start_id').html());
  }
}
