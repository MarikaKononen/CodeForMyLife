window.DustPressStarter = (function(window, document, $) {

    var app = {
        currentPage: 1
    };

    app.cache = function () {
        app.$mainContainer  = $("#main-content");
        app.$postsContainer = $("#post-list-container");
        app.$loadMore       = app.$mainContainer.find("#load-more");
        app.maxNumPages     = parseInt(app.$loadMore.data('max-num-pages'));
    };

    app.init = function() {
        app.cache();

        app.$loadMore.on("click", app.loadMore);
    };

    app.loadMore = function (e) {
        if ( e.preventDefault ) {
            e.preventDefault;
        }

        // Load more with DustPress.js
        dp("PageArchive/Query", {
            args: {
                page: ++app.currentPage
            },
            tidy: true,
            partial: "post-list",
            success: function(response) {
                app.$postsContainer.append(response);
                if ( app.currentPage === app.maxNumPages ) {
                    app.$loadMore.hide();
                }
            },
            error: function( error ) {
                console.log(error);
            }
        });

        return false;
    };

    app.init();

    return app;

}(window, document, jQuery));