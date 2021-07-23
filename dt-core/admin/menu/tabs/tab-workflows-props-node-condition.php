<?php
?>
<div style="display: none;" id="workflows_props_node_condition">
    <table style="min-width: 100%;">
        <tr>
            <td style="text-align: right;">id:</td>
            <td id="workflows_props_node_condition_id">akdnfjk2r333r2fr232r</td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align: middle;">name:</td>
            <td>
                <input type="text" style="min-width: 100%;" id="workflows_props_node_condition_name"
                       value="[ condition ]">
            </td>
        </tr>
        <tr>
            <td colspan="2">condition builder:
                <hr>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align: middle;">post:</td>
            <td>
                <select style="min-width: 100%;" id="workflows_props_node_condition_post_types_list">
                    <option disabled selected value="">--- post types ---</option>
                    <option value="contacts">contacts</option>
                    <option value="groups">groups</option>
                </select>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align: middle;">field:</td>
            <td>
                <select style="min-width: 100%;" id="workflows_props_node_condition_post_fields_list">
                    <option disabled selected value="">--- fields ---</option>
                    <option value="id">id</option>
                    <option value="name">name</option>
                    <option value="title">title</option>
                    <option value="milestones">milestones</option>
                    <option value="emails">emails</option>
                </select>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align: middle;">event:</td>
            <td>
                <select style="min-width: 100%;" id="workflows_props_node_condition_operators_list">
                    <option disabled selected value="">--- conditions ---</option>
                    <option value="equals">Equals</option>
                    <option value="not_equals">Not Equal</option>
                    <option value="greater">Greater Than</option>
                    <option value="less">Less Than</option>
                    <option value="contains">Contains</option>
                    <option value="assigned">Assigned To</option>
                    <option value="not_assigned">Not Assigned To</option>
                </select>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align: middle;">value:</td>
            <td>
                <input type="text" style="min-width: 100%;" id="workflows_props_node_condition_value" value="">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span style="float:right;">
                    <a id="workflows_props_node_condition_add_but"
                       class="button float-right"><?php esc_html_e( "Add Rule", 'disciple_tools' ) ?></a>
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="2">selected rules:
                <hr>
            </td>
        </tr>
        <tr>
            <table style="min-width: 100%;" id="workflows_props_node_condition_selected_rules">
                <tr>
                    <td style="vertical-align: middle;">contacts -> name -> Equals -> Jon :)</td>
                    <td style="vertical-align: middle;">
                        <span style="float:right;">
                            <a id="workflows_props_node_condition_rule_remove_but"
                               class="button float-right"><?php esc_html_e( "Remove", 'disciple_tools' ) ?></a>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;">contacts -> emails -> Contains -> @</td>
                    <td style="vertical-align: middle;">
                        <span style="float:right;">
                            <a id="workflows_props_node_condition_rule_remove_but"
                               class="button float-right"><?php esc_html_e( "Remove", 'disciple_tools' ) ?></a>
                        </span>
                    </td>
                </tr>
            </table>
        </tr>
        <tr>
            <td colspan="2">
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span style="float:right;">
                    <a id="workflows_props_node_condition_delete_but"
                       class="button float-right"><?php esc_html_e( "Delete Condition", 'disciple_tools' ) ?></a>
                    <a id="workflows_props_node_condition_update_but"
                       class="button float-right"><?php esc_html_e( "Update", 'disciple_tools' ) ?></a>
                </span>
            </td>
        </tr>
    </table>
</div>
