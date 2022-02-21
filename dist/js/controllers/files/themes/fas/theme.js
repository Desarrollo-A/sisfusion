/*!
 * bootstrap-fileinput v5.1.1
 * http://plugins.krajee.com/file-input
 *
 * Font Awesome 5 icon theme configuration for bootstrap-fileinput. Requires font awesome 5 assets to be loaded.
 *
 * Author: Kartik Visweswaran
 * Copyright: 2014 - 2020, Kartik Visweswaran, Krajee.com
 *
 * Licensed under the BSD-3-Clause
 * https://github.com/kartik-v/bootstrap-fileinput/blob/master/LICENSE.md
 */
(function ($) {
    "use strict";

    $.fn.fileinputThemes.fas = {
        fileActionSettings: {
            removeIcon: '<i class="material-icons">delete</i>',
            uploadIcon: '<i class="material-icons">cloud_upload</i>',
            uploadRetryIcon: '<i class="fas fa-redo-alt"></i>',
            downloadIcon: '<i class="material-icons">cloud_download</i>',
            zoomIcon: '<i class="material-icons">visibility</i>',
            dragIcon: '<i class="fas fa-arrows-alt"></i>',
            indicatorNew: '<i class="material-icons">add</i>',
            indicatorSuccess: '<i class="material-icons">done</i>',
            indicatorError: '<i class="material-icons">close</i>',
            indicatorLoading: '<i class="material-icons">hourglass_full</i>',
            indicatorPaused: '<i class="material-icons">pause</i>'
        },
        layoutTemplates: {
            fileIcon: '<i class="material-icons">insert_drive_file</i> '
        },
        previewZoomButtonIcons: {
            prev: '<i class="material-icons">navigate_before</i>',
            next: '<i class="material-icons">navigate_next</i>',
            toggleheader: '<span class="material-icons">open_with</span>',
            fullscreen: '<span class="material-icons">fullscreen</span>',
            borderless: '<i class="material-icons">open_in_new</i>',
            close: '<i class="material-icons">close</i>'
        },
        previewFileIcon: '<i class="material-icons">insert_drive_file</i>',
        browseIcon: '<i class="material-icons">folder_open</i>',
        removeIcon: '<i class="material-icons">delete</i>',
        cancelIcon: '<i class="material-icons">report_off</i>',
        pauseIcon: '<i class="material-icons">pause</i>',
        uploadIcon: '<i class="material-icons">cloud_upload</i>',
        msgValidationErrorIcon: '<i class="material-icons">error</i></i> '
    };
})(window.jQuery);
