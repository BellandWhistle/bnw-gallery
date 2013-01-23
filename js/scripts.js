window.GLRYAPP = {
    current_url: null,
    start: function () {
        var workspace = new Workspace();
        Backbone.history.start({
            pushState: true
        });
    }
};
$(document).ready(function () {
    /* Modelos */
    var GalleryModel = Backbone.Model.extend({
        'urlRoot': GLRY_data.base_dir + 'api.php?action=get_gallery',
        parse: function (data) {
            return data;
        }
    });
    var AlbumModel = Backbone.Model.extend({
        'urlRoot': GLRY_data.base_dir + 'api.php?action=get_album',
        initialize: function () {}
    });
    var GalleryCollection = Backbone.Collection.extend({
        url: GLRY_data.base_dir + 'api.php?action=get_gallery',
        model : GalleryModel,
        initialize: function () {},
        parse: function (response) {
            return response.albums
        }
    });
    var PhotoCollection = Backbone.Collection.extend({
        next: function (model) {
            var i = this.indexOf(model);
            if (typeof i == 'undefined' || undefined === i || i < 0) return false;
            return this.at(i + 1);
        },
        prev: function (model) {
            var i = this.indexOf(model);
            // if ( typeof i == 'undefined' || undefined === i || i < 1) return false;
            return this.at(i - 1);
        }
    });
    /* Vistas */
    var GalleryView = Backbone.View.extend({
        el: '#gallery_base',
        model: GalleryModel,
        // collection : GalleryCollection,
        events: {
            "click .wp-pagenavi a": 'goto',
            "click .album_item a": 'goto'
        },
        initialize: function () {
            _.bindAll(this, 'render');
            // Vista anidada. Lista de albums
            this.AlbumItemView = new AlbumItemView({
                'collection': this.model.get('albums')
            });
        },
        render: function () {
            this.$el.html(_.template($('#GalleryView').html())); // pero si no se le pasa data no es innecesario el _.template?
            this.$el.find('.pagination_container').html(this.model.get('pagination'));
            // Album List
            this.$el.find('.thumb_list_container').append(this.AlbumItemView.$el);
            this.AlbumItemView.render();
            $('#unique_view').attr('class', 'gallery');
            this.collection = new GalleryCollection(this.model.get('albums'));
            this.delegateEvents();
        },
        goto: function (e) {
            var target = e.currentTarget;
            var href = $(target).attr('href').slice(GLRY_data.glry_base_url.length);
            Backbone.history.navigate(href, true);
            e.preventDefault();
        }
    });
    var AlbumItemView = Backbone.View.extend({
        tagName: 'ul',
        attributes: {
            'class': 'thumb_list'
        },
        // collection: AlbumItemCollection,
        AlbumItemViewTemplate: _.template($('#AlbumItemView').html()),
        initialize: function () {},
        render: function () {
            var self = this;
            _.each(this.collection, function (item) {
                self.$el.append(self.AlbumItemViewTemplate(item));
            });
            this.delegateEvents();
        }
    });
    // Vista general de album
    var AlbumView = Backbone.View.extend({
        el: '#gallery_base',
        model: AlbumModel,
        events: {
            'click .navigate': 'goto',
            'click .photo_item a': 'goto',
            'click .back_to_slidehow': 'goto'
        },
        initialize: function () {
            this.PhotoItemView = new PhotoItemView({
                'collection': this.model.get('photos')
            });
        },
        render: function () {
            var data = {
                'album_title' : this.model.get('album_title'),
                'album_url' : this.model.get('album_url'),
                'post_url' : this.model.get('post_url')
            };
            this.$el.html(_.template($('#AlbumView').html(), data));
            this.$el.find('.thumb_list_container').append(this.PhotoItemView.$el);
            this.PhotoItemView.render();
            $('#unique_view').attr('class', 'album');
            this.delegateEvents();
        },
        goto: function (e) {
            e.preventDefault();
            var target = e.currentTarget;
            var href = $(target).attr('href').slice(GLRY_data.glry_base_url.length);
            Backbone.history.navigate(href, true);
        }
    });
    var PhotoItemView = Backbone.View.extend({
        tagName: 'ul',
        attributes: {
            'class': 'thumb_list'
        },
        PhotoListViewTemplate: _.template($('#PhotoItemView').html()),
        render: function () {
            var self = this;
            _.each(this.collection, function (item) {
                self.$el.append(self.PhotoListViewTemplate(item));
            });
            this.delegateEvents();
        },
        goto: function (e) {
            e.preventDefault();
            var target = e.currentTarget;
            var href = $(target).attr('href').slice(GLRY_data.glry_base_url.length);
            Backbone.history.navigate(href, true);
        }
    });
    var PhotoView = Backbone.View.extend({
        el: '#gallery_base',
        events: {
            'click .main_navigation a': 'goto',
            'click .view_thumbnails': 'goto',
            'click .navigate': 'goto'
        },
        initialize: function () {
            var self = this;
            _.bindAll(this, 'render');
        },
        detach: function () {
            $(this.el).unbind();
        },
        render: function () {
            var data = $.extend(true, {}, this.model, this.options.pagedata);
            this.detach();
            this.$el.empty();
            this.$el.html(_.template($('#PhotoView').html(), data));
            $('#unique_view').attr('class', 'photo');
            this.delegateEvents();
        },
        goto: function (e) {
            e.preventDefault();
            var target = e.currentTarget,
                href = $(target).attr('href').slice(GLRY_data.glry_base_url.length);
            Backbone.history.navigate(href, true);
            return false;
        }
    });
    window.Workspace = Backbone.Router.extend({
        gallerymodel: null,
        albummodel: null,
        routes: {
            '*path/gallery': 'gallery',
            '*path/gallery/': 'gallery',
            '*path/gallery/page/:num': 'gallery',
            '*path/:postname.html/album': 'album',
            '*path/:postname.html/attachment/:postname': 'photo'
        },
        initialize: function () {
            _.bindAll(this, 'gallery', 'album', 'photo');
        },
        gallery: function (isGallery, whatPage) {
            var self = this;
            this.gallerymodel = new GalleryModel();
            this.gallerymodel.fetch({
                data: $.param({
                    'paged': whatPage
                })
            }).complete(function () {
                self.galleryview = new GalleryView({
                    model: self.gallerymodel
                });
                self.galleryview.render();
            });
        },
        album: function (x, albumname) {
            var self = this;
            this.albummodel = new AlbumModel();
            this.albummodel.fetch({
                data: $.param({
                    'albumname': albumname
                })
            }).complete(function () {
                self.albumview = new AlbumView({
                    model: self.albummodel
                });
                self.albumview.render();
            });
        },
        photo: function (a, albumname, photoname) {
            self = this;
            if (this.albummodel) {
                this.photocollection = new PhotoCollection(this.albummodel.get('photos'));
                this.current_photo = this.photocollection.where({
                    'photoname': photoname
                })[0];
                this.next_photo = this.photocollection.next(this.current_photo);
                this.prev_photo = this.photocollection.prev(this.current_photo);
                this.next_photo_url = this.next_photo ? this.next_photo.get('permalink') : '';
                this.prev_photo_url = this.prev_photo ? this.prev_photo.get('permalink') : '';
                this.photomodel = _.first(_.where(this.albummodel.get('photos'), {
                    'photoname': photoname
                }));
                this.photoview = new PhotoView({
                    'model': self.photomodel,
                    'pagedata': {
                        'post_url': this.albummodel.get('post_url'),
                        'prev_photo_url': this.prev_photo_url,
                        'next_photo_url': this.next_photo_url,
                        'album_title': this.albummodel.get('album_title'),
                        'album_url': this.albummodel.get('album_url'),
                        'total_photos': this.albummodel.get('total_photos')
                    }
                });
                this.photoview.render();
            } else {
                this.albummodel = new AlbumModel();
                this.albummodel.fetch({
                    data: $.param({
                        'albumname': albumname
                    })
                }).complete(function () {
                    self.photo(a, albumname, photoname);
                });
            }
        }
    });
    GLRYAPP.start();
});