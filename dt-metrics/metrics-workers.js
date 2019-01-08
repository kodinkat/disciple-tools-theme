jQuery(document).ready(function() {
    console.log( dtMetricsUsers )

    if( ! window.location.hash || '#workers_activity' === window.location.hash  ) {
        workers_activity()
    }
    if( '#follow_up_pace' === window.location.hash) {
        window.show_follow_up_pace()
    }
    if( '#contact_follow_up_pace' === window.location.hash) {
        contact_follow_up_pace()
    }

})

function workers_activity() {
    "use strict";
    let chartDiv = jQuery('#chart')
    jQuery('#metrics-sidemenu').foundation('down', jQuery('#workers-menu'));
    let sourceData = dtMetricsUsers.data
    chartDiv.empty().html(`
        <span style="float:right;"><i class="fi-info primary-color"></i> </span>
        <span class="section-header">${sourceData.translations.title_activity}</span>
        
        <br><br>
        <div class="grid-x grid-padding-x grid-padding-y">
            <div class="cell center callout">
                <div class="grid-x">
                    <div class="medium-3 cell center">
                        <h4>${sourceData.translations.label_total_workers}<br><span id="total_workers">0</span></h4>
                    </div>
                    <div class="medium-2 cell left-border-grey">
                        <h4>${sourceData.translations.label_total_multipliers}<br><span id="total_multipliers">0</span></h4>
                    </div>
                    <div class="medium-2 cell center">
                        <h4>${sourceData.translations.label_total_dispatchers}<br><span id="total_dispatchers">0</span></h4>
                    </div>
                    <div class="medium-2 cell center">
                        <h4>${sourceData.translations.label_total_administrators}<br><span id="total_administrators">0</span></h4>
                    </div>
                    <div class="medium-2 cell center">
                        <h4>${sourceData.translations.label_total_strategists}<br><span id="total_strategists">0</span>
                        </h4>
                    </div>
                    
                </div>
            </div>
            <div class="cell">
                <span class="section-subheader">${sourceData.translations.title_recent_activity}</span>
                <div id="chart_line_logins" style="height:300px"><img src="${dtMetricsUsers.theme_uri}/dt-assets/images/ajax-loader.gif" width="20px" /></div>
            </div>
            <div class="cell" style="display:none;">
                <div class="grid-x grid-padding-x">
                <div class="cell medium-6">
                        <span class="section-subheader">${sourceData.translations.label_most_active}</span>
                        <div id="most_active"><img src="${dtMetricsUsers.theme_uri}/dt-assets/images/ajax-loader.gif" width="20px" /></div>
                    </div>
                    <div class="cell medium-6">
                        <span class="section-subheader">${sourceData.translations.label_least_active}</span>
                        <div id="least_active"><img src="${dtMetricsUsers.theme_uri}/dt-assets/images/ajax-loader.gif" width="20px" /></div>
                    </div>
                </div>
            </div>
            <div class="cell">
                <hr>
                <p><span class="section-subheader">${sourceData.translations.label_contacts_per_user}</span></p>
                <div id="contact_progress_per_worker" ><img src="${dtMetricsUsers.theme_uri}/dt-assets/images/ajax-loader.gif" width="20px" /></div>
            </div>
            
        </div>
        `)

    let hero = sourceData.hero_stats
    jQuery('#total_workers').html( numberWithCommas( hero.total_workers ) )
    jQuery('#total_multipliers').html( numberWithCommas( hero.total_multipliers ) )
    jQuery('#total_dispatchers').html( numberWithCommas( hero.total_dispatchers ) )
    jQuery('#total_administrators').html( numberWithCommas( hero.total_administrators ) )
    jQuery('#total_strategists').html( numberWithCommas( hero.total_strategists ) )

    // build charts
    google.charts.load('current', {'packages':['corechart', 'line', 'table']});

    google.charts.setOnLoadCallback(drawLineChartLogins);
    google.charts.setOnLoadCallback(contact_progress_per_worker);
    google.charts.setOnLoadCallback(drawLeastActive);
    google.charts.setOnLoadCallback(drawMostActive);

    function drawLineChartLogins() {
        let chartData = google.visualization.arrayToDataTable( sourceData.recent_activity );
        let options = {
            vAxis: {title: 'logins'},
            chartArea: {
                left: '5%',
                width: "100%"
                 },
            legend: { position: 'bottom' }
        };
        let chart = new google.visualization.LineChart( document.getElementById('chart_line_logins') );

        chart.draw(chartData, options);
    }

    function contact_progress_per_worker() {

        jQuery.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            url: dtMetricsUsers.root + 'dt/v1/metrics/workers/contact_progress_per_worker',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-WP-Nonce', dtMetricsUsers.nonce);
            },
        })
            .done(function (response) {
                let chartData = google.visualization.arrayToDataTable( response );
                let options = {
                    chartArea: {
                        left: '5%',
                        top: '7%',
                        width: "100%",
                        height: "85%" },
                    legend: { position: 'bottom' },
                    alternatingRowStyle: true,
                    sort: 'enable',
                    // showRowNumber: true,
                    sortColumn: 0,
                    width: '100%',

                };
                let chart = new google.visualization.Table( document.getElementById('contact_progress_per_worker') );

                chart.draw(chartData, options);

                jQuery('.google-visualization-table-td:contains(0)').filter(function() {
                    return jQuery(this).text() === "0";
                }).addClass("grey");

            })
            .fail(function (err) {
                console.log("error")
                console.log(err)
                jQuery("#errors").append(err.responseText)
            })
    }

    function drawLeastActive() {
        let chartData = google.visualization.arrayToDataTable( [
            ['Name', 'Logins Last 30', 'Updates Last 30'],
            ['Jimmy', 3, 0 ],
            ['Lazardo', 0, 0 ]
        ] );
        let options = {
            chartArea: {
                left: '5%',
                top: '7%',
                width: "100%",
                height: "85%" },
            legend: { position: 'bottom' },
            alternatingRowStyle: true,
            sort: 'enable',
            showRowNumber: true,
            width: '100%',

        };
        let chart = new google.visualization.Table( document.getElementById('least_active') );

        chart.draw(chartData, options);
    }

    function drawMostActive() {
        let chartData = google.visualization.arrayToDataTable( [
            ['Name', 'Logins Last 30', 'Updates Last 30'],
            ['Over Achiever', 34, 23 ],
            ['Lazardo', 24, 34 ]
        ] );
        let options = {
            chartArea: {
                left: '5%',
                top: '7%',
                width: "100%",
                height: "85%" },
            legend: { position: 'bottom' },
            alternatingRowStyle: true,
            sort: 'enable',
            showRowNumber: true,
            width: '100%',

        };
        let chart = new google.visualization.Table( document.getElementById('most_active') );

        chart.draw(chartData, options);
    }

}

function contact_follow_up_pace(){
    "use strict";
    jQuery('#metrics-sidemenu').foundation('down', jQuery('#workers-menu'));
    let localizedObject = window.dtMetricsUsers
    let chartDiv = jQuery('#chart') // retrieves the chart div in the metrics page

    // TODO: escape this properly
    chartDiv.empty().html(`
      <span class="text-small" style="float:right; font-size:.6em; color: gray;">data as of <span id="pace-timestamp"></span> - <a onclick="refresh_worker_pace_data()">refresh</a></span>
      <span class="section-header">`+ localizedObject.data.translations.title_response +`</span>
      
      <hr style="max-width:100%;">
      <span><a onclick="jQuery('.notes').toggle();" style="float:right; font-size:.6em;">Show Chart Notes</a> </span>
      <p>
        <strong>Average Coalition Pace (ACP):</strong><br>
        Assigned-to-Accepted Pace: <strong id="coalition_assigned_to_accepted"></strong> Hours Average <br>
        Accepted-to-Attempted Pace: <strong id="coalition_accept_to_attempted"></strong> Hours Average 
      </p>

      <p class="notes" style="display:none;">Note: Except for baptisms, these numbers come from the contacts that the User is currently assigned to. This means that if Bob met the contact and then assigned it to Fred it counts as if Fred met the contact.</p>
      
      <p><strong>Per User Pace:</strong></p>
      <div id="followup-pace"></div>
      
    `)

    jQuery.ajax({
        type: "POST",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: dtMetricsUsers.root + 'dt/v1/metrics/workers/user_pace',
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-WP-Nonce', dtMetricsUsers.nonce);
        },
    })
        .done(function (response) {
            console.log(response)
            drawContactsProgressPerUser( response )
        })
        .fail(function (err) {
            console.log("error")
            console.log(err)
            jQuery("#errors").append(err.responseText)
        })

    google.charts.load('current', {'packages':['corechart', 'table']});
    // google.charts.setOnLoadCallback(drawContactsProgressPerUser);
    // google.charts.setOnLoadCallback(drawGenerationPace);

    function drawContactsProgressPerUser( response ) {
        let chartData = google.visualization.arrayToDataTable( response );

        let options = {
            chartArea: {
                left: '5%',
                top: '7%',
                width: "100%",
                height: "85%" },
            legend: { position: 'bottom' },
            alternatingRowStyle: true,
            sort: 'enable',
            // showRowNumber: true,
            width: '100%',

        };
        let chart = new google.visualization.Table( document.getElementById('followup-pace') );

        chart.draw(chartData, options);
    }


    // re-initialize foundation objects
    jQuery('#workers').foundation()
    jQuery('.tool-tip').foundation()
}


window.show_follow_up_pace = function show_follow_up_pace(){
    "use strict";
    jQuery('#metrics-sidemenu').foundation('down', jQuery('#workers-menu'));
    let localizedObject = window.dtMetricsUsers
    let chartDiv = jQuery('#chart') // retrieves the chart div in the metrics page

    // TODO: escape this properly
    chartDiv.empty().html(`
      <span class="text-small" style="float:right; font-size:.6em; color: gray;">data as of <span id="pace-timestamp"></span> - <a onclick="refresh_worker_pace_data()">refresh</a></span>
      <span class="section-header">`+ localizedObject.data.translations.title_response +`</span>
      
      <hr style="max-width:100%;">
      <span><a onclick="jQuery('.notes').toggle();" style="float:right; font-size:.6em;">Show Chart Notes</a> </span>
      <p><strong>Coalition Pace: <span id="coalition_time_to_attempt"></span> Hours Average</strong> <span data-tooltip data-hover-delay="0" class="top tool-tip" title="Time from assignment to contact attempt"><i class="fi-info"></i></span></p>

      <p class="notes" style="display:none;">Note: Except for baptisms, these numbers come from the contacts that the User is currently assigned to. This means that if Bob met the contact and then assigned it to Fred it counts as if Fred met the contact.</p>
      
      <div class="scrolling-wrapper">
      <table id="workers" class="hover table-scroll striped">
        <thead style="background-color: lightgrey;">
          <th onclick="sortTable(0)" style="white-space: nowrap;">Worker Name</th>
          <th onclick="sortTable(1)"  style="white-space: nowrap;">Pace <span data-tooltip data-hover-delay="0" class="top tool-tip" title="Time from assignment to contact attempt"><i class="fi-info"></i></span></th>
          <th onclick="sortTable(2)">New</th>
          <th onclick="sortTable(3)">Active</th>
          <th onclick="sortTable(4)">Update Needed</th>
          <th onclick="sortTable(5)">Assigned</th>
          <th onclick="sortTable(6)">Met</th>
          <th onclick="sortTable(7)">Baptized</th>
          <th onclick="sortTable(8)">Last Assignment</th>
        </thead>
        <tbody id="workers_table_body">
            
        </tbody>
      </table>
      </div>
    `)


    refresh_worker_pace_data()

    // re-initialize foundation objects
    jQuery('#workers').foundation()
    jQuery('.tool-tip').foundation()
}

function add_worker_pace_table( data) {
    let tableHTML = ``;
    // TODO: escape this properly
    data.forEach(worker=>{
        tableHTML +=`
      <tr>
        <td>${worker.display_name}</td>
        <td>${worker.avg_hours_to_contact_attempt || ""}</td>
        <td>${worker.number_new_assigned}</td>
        <td>${worker.number_active}</td>
        <td>${worker.number_update}</td>
        <td>${worker.number_assigned_to}</td>
        <td>${worker.number_met}</td>
        <td>${worker.number_baptized}</td>
        <td>${worker.last_date_assigned || ""}</td>
      </tr>
      `
    })
    jQuery("#workers_table_body").empty().html(tableHTML)
}

function refresh_worker_pace_data() {
    let table = jQuery('#workers_table_body')
    table.empty().html(`
            <tr><td colspan="8">
                <img src="${dtMetricsUsers.theme_uri}/dt-assets/images/ajax-loader.gif" width="20px" />
            </td></tr>`)

    return jQuery.ajax({
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: dtMetricsUsers.root + 'dt/v1/metrics/workers/workers_pace',
        beforeSend: function(xhr) {
            xhr.setRequestHeader('X-WP-Nonce', dtMetricsUsers.nonce);
        },
    })
        .done(function (response) {
            console.log(response)
            jQuery("#coalition_time_to_attempt").html(response.coalition_time_to_attempt)
            jQuery("#pace-timestamp").html(response.timestamp)
            add_worker_pace_table( response.data )
        })
        .fail(function (err) {
            console.log("error")
            console.log(err)
            jQuery("#errors").append(err.responseText)
        })
}

window.sortTable = function sortTable(n) {
    "use strict";
    let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("workers");
    switching = true;
    //Set the sorting direction to ascending:
    dir = "asc";
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
            one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            /*check if the two rows should switch place,
            based on the direction, asc or desc:*/
            if (dir === "asc") {

                if (Number.isInteger(parseInt(x.innerHTML))){
                    if (parseInt(x.innerHTML.replace("-", "")) > parseInt(y.innerHTML.replace("-", ""))) {
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    if (x.innerHTML.toLowerCase().replace("-", "") > y.innerHTML.toLowerCase().replace("-", "")) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch= true;
                        break;
                    }
                }
            } else if (dir === "desc") {
                if (Number.isInteger(parseInt(x.innerHTML)) ? (parseInt(x.innerHTML.replace("-", "")) < parseInt(y.innerHTML.replace("-", ""))) : (x.innerHTML.toLowerCase().replace("-", "") < y.innerHTML.toLowerCase().replace("-", ""))) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            //Each time a switch is done, increase this count by 1:
            switchcount ++;
        } else {
            /*If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again.*/
            if (switchcount === 0 && dir === "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}


function numberWithCommas(x) {
    x = x.toString();
    let pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}



