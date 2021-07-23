<?php
?>
<div style="display: none;" id="workflows_props_node_action">
    <table style="min-width: 100%;">
        <tr>
            <td style="text-align: right;">id:</td>
            <td id="workflows_props_node_action_id">akdnfjk2r333r2fr232r</td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align: middle;">name:</td>
            <td>
                <input type="text" style="min-width: 100%;" id="workflows_props_node_action_name"
                       value="[ action ]">
            </td>
        </tr>
        <tr>
            <td colspan="2">action builder:
                <hr>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align: middle;">post:</td>
            <td>
                <select style="min-width: 100%;" id="workflows_props_node_action_post_types_list">
                    <option disabled selected value="">--- post types ---</option>
                    <option value="contacts">contacts</option>
                    <option value="groups">groups</option>
                </select>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align: middle;">field:</td>
            <td>
                <select style="min-width: 100%;" id="workflows_props_node_action_post_fields_list">
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
            <td style="text-align: right; vertical-align: middle;">action:</td>
            <td>
                <select style="min-width: 100%;" id="workflows_props_node_action_outcomes_list">
                    <option disabled selected value="">--- outcomes ---</option>
                    <option value="update">Update</option>
                    <option value="add">Add</option>
                    <option value="remove">Remove</option>
                    <option value="assign">Assign</option>
                    <option value="check">Check</option>
                    <option value="uncheck">Uncheck</option>
                    <option value="notify">Notify</option>
                </select>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; vertical-align: middle;">value:</td>
            <td>
                <input type="text" style="min-width: 100%;" id="workflows_props_node_action_value" value="">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span style="float:right;">
                    <a id="workflows_props_node_action_delete_but"
                       class="button float-right"><?php esc_html_e( "Delete Action", 'disciple_tools' ) ?></a>
                    <a id="workflows_props_node_action_update_but"
                       class="button float-right"><?php esc_html_e( "Update", 'disciple_tools' ) ?></a>
                </span>
            </td>
        </tr>
    </table>
</div>
