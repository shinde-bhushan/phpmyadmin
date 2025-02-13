import $ from 'jquery';
import { AJAX } from '../../modules/ajax.ts';
import createProfilingChart from '../../modules/functions/createProfilingChart.ts';

/**
 * @fileoverview    Javascript functions used in server status query page
 * @name            Server Status Query
 *
 * @requires    jQueryUI
 */

/**
 * Unbind all event handlers before tearing down a page
 */
AJAX.registerTeardown('server/status/queries.js', function () {
    if (document.getElementById('serverstatusquerieschart') !== null) {
        var queryPieChart = $('#serverstatusquerieschart').data('queryPieChart');
        if (queryPieChart) {
            queryPieChart.destroy();
        }
    }
});

AJAX.registerOnload('server/status/queries.js', function () {
    // Build query statistics chart
    var cdata = [];
    try {
        if (document.getElementById('serverstatusquerieschart') !== null) {
            $.each($('#serverstatusquerieschart').data('chart'), function (key, value) {
                cdata.push([key, parseInt(value, 10)]);
            });

            $('#serverstatusquerieschart').data(
                'queryPieChart',
                createProfilingChart('serverstatusquerieschart', cdata)
            );
        }
    } catch (exception) {
        // Could not load chart, no big deal...
    }

    window.initTableSorter('statustabs_queries');
});
