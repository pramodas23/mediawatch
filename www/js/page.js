/*
 *		YUI sandbox to run on main page
 *
 *		@version 1.0.0
 */


YUI({
    groups: {
        mediawatch: {
            base:  mediawatch.baseurl,

            modules: {

                'mediawatch-io': {
                    fullpath: "/js/moduleIO.js",
                    requires: ["base-build", "io-base", "io-form", "widget", "json-parse"]
                },
                'mediawatch-panel': {
                    fullpath: "/js/modulePanel.js",
                    requires: [ "base-build", "panel", "mediawatch-io", "dd-plugin"]
                }
            }
        }
    },


    combine: true

}).use( 'mediawatch-io', 'mediawatch-panel', 'node-event-delegate',   function(Y) {




    var bodyContainer  = Y.one('#bodyContainer');



    // clicks on any speaker image within the container element will cause
    // a modal panel to open displaying the speaker's biosketch

    bodyContainer.delegate('click', function(e) {

        e.preventDefault();
        Y.log(e.currentTarget.getAttribute('href'));


        //retrieve & display relevant form partial from server
        var panel = new Y.MediaTest.Panel({
            panelType: 'dialog',
            panelTitle: 'Speaker Biography',
            getUrl : e.currentTarget.getAttribute('href')
        });

    }, '.speaker');



    Y.on('available', function(e) {
        var sort = Y.one('#sortOptions');
        sort.on('change', function(e) {
            var index = sort.get('selectedIndex');
            if(index > 0) {
                var url = sort.get("options").item(index).getAttribute('data-url');
                window.location = url;
            }
        })
    }, '#sortOptions');
});