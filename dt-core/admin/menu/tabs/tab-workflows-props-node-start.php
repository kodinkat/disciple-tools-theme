<?php
?>
<div style="display: none;" id="workflows_props_node_start">
    <table style="min-width: 100%;">
        <tr>
            <td style="text-align: right;">id:</td>
            <td id="workflows_props_node_start_id">akdnfjk2r333r2fr232r</td>
        </tr>
        <tr>
            <td style="text-align: right;">name:</td>
            <td id="workflows_props_node_start_name">[ start ]</td>
        </tr>
        <tr>
            <td style="text-align: right;">enabled:</td>
            <td>
                <input type="checkbox" id="workflows_props_node_start_enabled">
            </td>
        </tr>
        <tr>
            <td colspan="2">triggers:
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <select style="min-width: 100%;" id="workflows_props_node_start_triggers_available_list">
                    <option disabled selected value="">--- available actions ---</option>
                    <option value="dt_post_created">dt_post_created</option>
                    <option value="dt_post_updated">dt_post_updated</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span style="float:right;">
                    <a id="workflows_props_node_start_add_but"
                       class="button float-right"><?php esc_html_e( "Add Trigger", 'disciple_tools' ) ?></a>
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="2">selected triggers:
                <hr>
            </td>
        </tr>
        <tr>
            <table style="min-width: 100%;" id="workflows_props_node_start_triggers_selected_list">
                <tr>
                    <td style="vertical-align: middle;">dt_post_created</td>
                    <td style="vertical-align: middle;">
                        <span style="float:right;">
                            <a id="workflows_props_node_start_trigger_remove_but"
                               class="button float-right"><?php esc_html_e( "Remove", 'disciple_tools' ) ?></a>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;">dt_post_updated</td>
                    <td style="vertical-align: middle;">
                        <span style="float:right;">
                            <a id="workflows_props_node_start_trigger_remove_but"
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
                    <a id="workflows_props_node_start_update_but"
                       class="button float-right"><?php esc_html_e( "Update", 'disciple_tools' ) ?></a>
                </span>
            </td>
        </tr>
    </table>
</div>
