; (function ($, window, document, undefined) {

    'use strict';

    var Modernizr = window.Modernizr;

    //1. Plugin constructor
    function GlassCase(element, options) {
        var gcBase = this;

        gcBase.element = element.wrap('<div class="glass-case"></div>').parent();
        gcBase.init(options);
    }

    //2. Object with the default options of the plugin
    GlassCase.defaults = {
        //DISPLAY AREA
        widthDisplay: 400,        // Default width of the display image
        heightDisplay: 534,        // Default height of the display image
        isAutoScaleDisplay: true,
        isAutoScaleHeight: true,
        isDownloadEnabled: true,
        downloadPosition: 3,
        isShowAlwaysIcons: false,
        speedHideIcons: 3000,
        mouseEnterDisplayCB: function () { },
        mouseLeaveDisplayCB: function () { },
        //THUMBS AREA        
        thumbsPosition: 'bottom',   // Default position of thumbs. Position is relative to the image display. Can take the values: top; bottom      
        nrThumbsPerRow: 5,          // Number of images per row        
        isThumbsOneRow: true,     // Show one row or all images: true -> will be shown only one row; false -> will be shown all images
        isOneThumbShown: false,
        firstThumbSelected: 0,          // Current element's index
        colorActiveThumb: -1,
        thumbsMargin: 4,          // in px
        isHoverShowThumbs: false,
        //ZOOM AREA
        zoomPosition: 'right',    // Default position for the zoom. It can take values: right; left; inner
        autoInnerZoom: true,       // true; false
        isZoomEnabled: true,
        isSlowZoom: false,
        speedSlowZoom: 1200,
        isZoomDiffWH: false,
        zoomWidth: 0,
        zoomHeight: 0,
        zoomAlignment: 'displayImage', //displayImage, displayArea
        zoomMargin: 4,          // in px    
        //LENS AREA
        isSlowLens: false,
        speedSlowLens: 600,
        //OVERLAY AREA
        isOverlayEnabled: true,
        isOverlayFullImage: false,
        //GENERAL
        speed: 400,        // Default speed
        easing: 'linear',   // Default easing
        isKeypressEnabled: true,
        colorIcons: -1,          // The color of the icons
        colorLoading: -1,
        textImageNotLoaded: 'NO IMAGE',
        //CAPTION
        isZCapEnabled: true,
        capZType: 'in', // in, out
        capZPos: 'bottom', // top, bottom
        capZAlign: 'center' // left, center, right
    };

    //3. Adding methods to the plugin object
    GlassCase.prototype = {
        init: function (options) {
            var gcBase = this;

            // Merging user's options with the default options
            gcBase.config = $.extend(true, {}, GlassCase.defaults, options);

            // Saving user's options to a private object
            gcBase._options = options;

            // GlassCase defaults
            gcBase._defaults = GlassCase.defaults;

            gcBase.iOS = false;
            var p = window.navigator.platform;

            if (p === 'iPad' || p === 'iPhone' || p === 'iPod') {
                gcBase.iOS = true;
            }

            gcBase.supportCanvas = Modernizr.canvas;

            var ctntDisplayArea = "<div class='gc-display-area'>" +
                                        "<div class='gc-icon gc-icon-download'></div>" +
                                        "<div class='gc-icon gc-icon-next'></div>" +
                                        "<div class='gc-icon gc-icon-prev'></div>" +
                                        "<div class='gc-display-container'>" +
                                            "<div class='gc-lens'></div>" +
                                            "<img class='gc-display-display' alt=' ' />" +
                                        "</div>" +
                                     "</div>";
            var ctntZoomArea = "<div class='gc-zoom'>" +
                                        "<div class='gc-zoom-container'><img alt=' ' /></div>" +
                                     "</div>";
            var ctntOverlayArea = "<div class='gc-overlay-area'>" +
                                    "<div class='gc-overlay-top-icons'>" +
                                     "<div class='gc-icon gc-icon-close'>&nbsp;</div>" +
                                        "<div class='gc-icon gc-icon-enlarge'>&nbsp;</div>" +
                                        "<div class='gc-icon gc-icon-compress'>&nbsp;</div>" +
                                    "</div>" +
                                    "<div class='gc-overlay-left-icons'>" +
                                        "<div class='gc-icon gc-icon-prev'>&nbsp;</div>" +
                                    "</div>" +
                                    "<div class='gc-overlay-right-icons'>" +
                                        "<div class='gc-icon gc-icon-next'>&nbsp;</div>" +
                                    "</div>" +
                                    "<div class='gc-overlay-gcontainer'>" +
                                        "<div class='gc-overlay-container'>" +
                                            "<div class='gc-overlay-container-display'>" +
                                                "<img class='gc-overlay-display' alt=' ' />" +
                                            "</div>" +
                                        "</div>" +
                                    "</div>" +
                                 "</div>";

            var sVT = (gcBase.config.thumbsPosition == 'right' || gcBase.config.thumbsPosition == 'left') ? '-vt' : '';

            var ctntThumbsPrevNext = "<div class='gc-thumbs-area-prev'><div class='gc-icon gc-icon-prev" + sVT + "'></div></div>" +
                                     "<div class='gc-thumbs-area-next'><div class='gc-icon gc-icon-next" + sVT + "'></div></div>";
            // Setting the position of the thumb images
            gcBase.widthDisplayPerc = 100;
            if (gcBase.config.thumbsPosition == 'top' || gcBase.config.thumbsPosition == 'left') {
                gcBase.element.append(ctntDisplayArea);
            }
            else {
                gcBase.element.prepend(ctntDisplayArea);
            }
            gcBase.element.prepend(ctntZoomArea).prepend(ctntOverlayArea);

            // Plugin variables
            // Loading
            gcBase.gcLoadingClass = (Modernizr.csstransforms == true) ? 'gc-loading3' : 'gc-loading';

            gcBase.gcLoader = $("<div class='" + gcBase.gcLoadingClass + "'></div>");
            gcBase.gcLoading = gcBase.element.find('.' + gcBase.gcLoadingClass);
            if (gcBase.config.colorLoading != -1 && Modernizr.csstransforms == true) {
                var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(gcBase.config.colorLoading);
                if (result) {
                    var sC = 'rgba(' + parseInt(result[1], 16) + ', ' + parseInt(result[2], 16) + ', ' + parseInt(result[3], 16) + ', ';
                    gcBase.gcLoader.css({ 'border-top-color': sC + '0.2)', 'border-right-color': sC + '0.2)', 'border-bottom-color': sC + '0.2)', 'border-left-color': sC + '1)' });
                }
            }
            // gcImageData: Array that will hold the sizes of all the images
            gcBase.gcImageData = [];
            // Display: Area, Container, Display, Lens, Download Icon
            gcBase.gcDisplayArea = gcBase.element.find('.gc-display-area');
            gcBase.gcDisplayContainer = gcBase.gcDisplayArea.find('.gc-display-container');
            gcBase.gcDisplayDisplay = gcBase.gcDisplayContainer.find('.gc-display-display');
            gcBase.gcLens = gcBase.gcDisplayContainer.find('.gc-lens').hide();
            gcBase.gcDisplayDownload = gcBase.gcDisplayArea.find('.gc-icon-download');
            gcBase.gcDisplayPrevious = gcBase.gcDisplayArea.find('.gc-icon-prev');
            gcBase.gcDisplayNext = gcBase.gcDisplayArea.find('.gc-icon-next');
            // Zoom: Area, Display
            gcBase.gcZoom = gcBase.element.find('.gc-zoom').hide();
            gcBase.gcZoomContainer = gcBase.gcZoom.find('.gc-zoom-container');
            gcBase.gcZoomDisplay = gcBase.gcZoomContainer.find('img');
            // Overlay: Area, Display, Close Icon, Previous Icon, Next Icon
            gcBase.gcOverlayArea = gcBase.element.find('.gc-overlay-area').hide();
            gcBase.gcOverlayGContainer = gcBase.gcOverlayArea.find('.gc-overlay-gcontainer');
            gcBase.gcOverlayContainer = gcBase.gcOverlayArea.find('.gc-overlay-container');
            gcBase.gcOverlayContainerDisplay = gcBase.gcOverlayContainer.find('.gc-overlay-container-display');
            gcBase.gcOverlayDisplay = gcBase.gcOverlayContainer.find('.gc-overlay-display');
            gcBase.gcOverlayPrevious = gcBase.gcOverlayArea.find('.gc-icon-prev');
            gcBase.gcOverlayNext = gcBase.gcOverlayArea.find('.gc-icon-next');
            gcBase.gcOverlayClose = gcBase.gcOverlayArea.find('.gc-icon-close');
            gcBase.gcOverlayEnlarge = gcBase.gcOverlayArea.find('.gc-icon-enlarge').hide();
            gcBase.gcOverlayCompress = gcBase.gcOverlayArea.find('.gc-icon-compress').hide();
            // Thumbs: Area, Ul, Li, AreaPrevious, AreaNext, Previous, Next, Img, LiDiv
            gcBase.gcThumbsUl = gcBase.element.find('ul');
            gcBase.gcThumbsUl.wrap("<div class='gc-thumbs-area'></div>");
            gcBase.gcThumbsArea = gcBase.element.find('.gc-thumbs-area');
            gcBase.gcThumbsArea.append(ctntThumbsPrevNext);
            gcBase.gcThumbsAreaPrevious = gcBase.gcThumbsArea.find('.gc-thumbs-area-prev');
            gcBase.gcThumbsPrevious = gcBase.gcThumbsAreaPrevious.find('.gc-icon-prev' + sVT);
            gcBase.gcThumbsAreaNext = gcBase.gcThumbsArea.find('.gc-thumbs-area-next');
            gcBase.gcThumbsNext = gcBase.gcThumbsAreaNext.find('.gc-icon-next' + sVT);
            gcBase.gcThumbsLi = gcBase.gcThumbsUl.find('li');

            gcBase.gcThumbsLi.each(function (index) {
                var iSrc = $.trim($(this).find('img').attr('src'));
                var els = gcBase.gcThumbsLi.find('img[src="' + iSrc + '"]');

                while (els.length > 1) {
                    els.last().parent().remove();
                    gcBase.gcThumbsLi = gcBase.gcThumbsUl.find('li');
                    els = gcBase.gcThumbsLi.find('img[src="' + iSrc + '"]');
                }
            });
            gcBase.gcThumbsLi = gcBase.gcThumbsUl.find('li');
            gcBase.gcThumbsImg = gcBase.gcThumbsLi.find('img');
            gcBase.gcThumbsImg.wrap('<div class="gc-li-display-container"></div>');
            gcBase.gcThumbsLiDiv = gcBase.gcThumbsLi.find('.gc-li-display-container');
            gcBase.gcThumbsUl.removeClass('gc-start');

            gcBase.gcTotalThumbsImg = gcBase.gcThumbsImg.length;
            // Caption
            var cssClass;

            if (gcBase.config.isZCapEnabled === true) {
                gcBase.gcCaption = $('<div class="gc-caption-container"><div></div></div>');
                gcBase.gcCaptionDisplay = gcBase.gcCaption.find('div');

                if (gcBase.config.zoomPosition === 'inner') gcBase.config.capZType = 'in';

                cssClass = 'gc-caption-' + gcBase.config.capZType + gcBase.config.capZPos;
                if ($.inArray(cssClass, ['gc-caption-outtop', 'gc-caption-outbottom', 'gc-caption-intop', 'gc-caption-inbottom']) === -1) {
                    cssClass = 'gc-caption-' + gcBase._defaults.capZType + gcBase._defaults.capZPos;
                }

                $.inArray(gcBase.config.capZAlign, ['left', 'right', 'center']) === -1 ?
                    cssClass += ' gc-alignment-' + gcBase._defaults.capZAlign :
                    cssClass += ' gc-alignment-' + gcBase.config.capZAlign;

                gcBase.gcCaption.addClass(cssClass).appendTo(gcBase.gcZoom);
            }
            gcBase.isMouseEventsOn = false;
            gcBase.isTouchMove = false;
            gcBase.mouseTimer = 0;

            if (gcBase.config.isShowAlwaysIcons != true) {
                gcBase.gcDisplayDownload.hide();
                gcBase.gcDisplayPrevious.hide();
                gcBase.gcDisplayNext.hide();
            }
            gcBase.isAutoInnerZooming = false;

            if (gcBase.config.zoomPosition == 'inner') {
                gcBase.config.isZoomDiffWH = true; gcBase.config.zoomWidth = 0; gcBase.config.zoomHeight = 0;
            }
            if (gcBase.config.thumbsPosition == 'left' || gcBase.config.thumbsPosition == 'right') {
                gcBase.gcThumbsArea.addClass('gc-vt');
            } else {
                gcBase.gcThumbsArea.addClass('gc-hz');
            }

            if (gcBase.config.colorIcons != -1) {
                gcBase.element.find('.gc-icon').css('color', gcBase.config.colorIcons);
            }

            if (gcBase.config.isDownloadEnabled == false || gcBase.supportCanvas == false) {
                gcBase.gcDisplayDownload.addClass('gc-hide');
            }
            else {
                var cssDownloadPosition = { top: '', bottom: '', right: '', left: '' };
                var bW = '-' + gcBase.gcDisplayArea.css('border-left-width');
                switch (gcBase.config.downloadPosition) {
                    case 1:
                        cssDownloadPosition.top = bW;
                        cssDownloadPosition.left = bW;
                        break;
                    case 2:
                        cssDownloadPosition.top = bW;
                        cssDownloadPosition.right = bW;
                        break;
                    case 4:
                        cssDownloadPosition.bottom = bW;
                        cssDownloadPosition.right = bW;
                        break;
                    default:
                        cssDownloadPosition.bottom = bW;
                        cssDownloadPosition.left = bW;
                        break;
                }
                gcBase.gcDisplayDownload.css(cssDownloadPosition);
            }

            if (isNaN(gcBase.config.firstThumbSelected) == false &&
                parseFloat(gcBase.config.firstThumbSelected) > -1 &&
                parseFloat(gcBase.config.firstThumbSelected) <= (gcBase.gcThumbsLi.length - 1)) {
                gcBase.current = gcBase.config.firstThumbSelected;
            }
            else {
                gcBase.current = gcBase._defaults.firstThumbSelected;
            }

            gcBase.currentSlide = Math.floor(gcBase.current / gcBase.config.nrThumbsPerRow);
            gcBase.old = 0;
            gcBase.currentMousePos = { x: -1, y: -1 };
            gcBase.resizeTimer = 0;
            gcBase.zooming = false;
            gcBase.newZoom = { left: 0, top: 0 };
            gcBase.currentZoom = { left: 0, top: 0 };
            gcBase.slowZoomTimer = 0;
            gcBase.newLens = { left: 0, top: 0 };
            gcBase.currentLens = { left: 0, top: 0 };
            gcBase.slowLensTimer = 0;

            var altTxt = gcBase.gcThumbsLi.eq(gcBase.current).find('img').attr('alt');
            if (altTxt === undefined) altTxt = 'image';

            gcBase.gcDisplayDisplay.attr('src', gcBase.gcThumbsImg.eq(gcBase.current).attr('src'))
                                   .attr('alt', altTxt);
            gcBase.setup();

            $.when(gcBase.preloadImages()).done(function () {
                gcBase.update();
                gcBase.initEvents();
            });
        },
        preloadImages: function () {
            var gcBase = this;

            var countLoadedImages = 0,
                countTotalImages = gcBase.gcTotalThumbsImg;

            // Object that will hold the natural sizes of the image
            function GCImageData(width, height, isLoaded, src) {
                this.width = width;
                this.height = height;
                this.isLoaded = isLoaded;
            };

            return $.Deferred(
				function (dfd) {
				    gcBase.gcThumbsImg.each(function (index) {
				        $('<img/>')
                        .on('load', function () {
                            var lWidth = this.width,
                                lHeight = this.height,
                                lGCImageData = new GCImageData(lWidth, lHeight, true),
                                index = gcBase.gcThumbsLi.find("img[src*='" + $(this).attr('src') + "']").parents('li').index();
                            gcBase.gcImageData[index] = lGCImageData;
                            gcBase.processThumbImage(index);
                            if (++countLoadedImages === countTotalImages) { dfd.resolve(); }
                        })
                        .on('error', function () {
                            var index = gcBase.gcThumbsLi.find("img[src*='" + $(this).attr('src') + "']").parents('li').index(),
                                lWidth = gcBase.gcThumbsLi.width(),
                                lHeight = gcBase.gcThumbsLi.height(),
                                lGCImageData = new GCImageData(lWidth, lHeight, false);
                            gcBase.gcImageData[index] = lGCImageData;

                            this.onerror = "";

                            if (Modernizr.svg) {
                                var iEDB64 = window.btoa("<svg xmlns='http://www.w3.org/2000/svg' width='" + lWidth + "' height='" + lHeight + "'><rect width='" + lWidth + "' height='" + lHeight + "' fill='#eee'/><text text-anchor='middle' x='" + lWidth / 2 + "' y='" + lHeight / 2 + "' style='fill:#aaa;font-weight:bold;font-size:8px;font-family:Arial,Helvetica,sans-serif;dominant-baseline:central'>" + gcBase.config.textImageNotLoaded + "</text></svg>");
                                gcBase.gcThumbsImg.eq(index).attr('src', "data:image/svg+xml;base64," + iEDB64);
                            }
                            gcBase.processThumbImage(index);
                            if (++countLoadedImages === countTotalImages) { dfd.resolve(); }
                        }).attr('src', $(this).attr('src'));
				    });
				}
			).promise();
        },
        processThumbImage: function (index) {
            var gcBase = this;

            gcBase.setupThumbImg(gcBase.gcThumbsLi.eq(index), index);
            gcBase.removeLoader(gcBase.gcThumbsLi.eq(index));
            gcBase.gcThumbsLi.eq(index).find('.gc-li-display-container').removeClass('gc-hide');

            if (gcBase.current == index) {
                gcBase.removeLoader(gcBase.gcDisplayArea);
                gcBase.gcDisplayContainer.removeClass('gc-hide');
                gcBase.setupDisplayDisplay();
                gcBase.setupLens();
            }
        },
        setup: function () {
            var gcBase = this;

            var gcWidth;
            if ((gcBase.config.thumbsPosition == 'right' || gcBase.config.thumbsPosition == 'left') &&
                (gcBase.config.isOneThumbShown == false && (gcBase.gcThumbsLi.length > 1))) {
                var liMargin = parseFloat(gcBase.gcThumbsLi.css('margin-bottom')),
                    heightLi = (parseFloat(gcBase.config.heightDisplay) / gcBase.config.nrThumbsPerRow - (gcBase.config.nrThumbsPerRow - 1) * liMargin / gcBase.config.nrThumbsPerRow),
                    ratio = gcBase.config.widthDisplay / gcBase.config.heightDisplay,
                    widthLi = heightLi * ratio;
                var wE = widthLi + gcBase.config.thumbsMargin + parseFloat(gcBase.config.widthDisplay);

                gcBase.widthDisplayPerc = Math.round(gcBase.config.widthDisplay * 100 / wE);

                gcWidth = gcBase.element.parent().width() > wE ? wE : gcBase.element.parent().width();

            } else {
                gcWidth = gcBase.element.parent().width() > gcBase.config.widthDisplay ? (gcBase.config.widthDisplay) : gcBase.element.parent().width();
            }

            gcBase.element.css({ 'width': gcWidth });

            // DISPLAY
            gcBase.setupDisplayArea();
            // THUMBS
            if (gcBase.config.isOneThumbShown == false && gcBase.gcTotalThumbsImg == 1) {
                gcBase.gcThumbsArea.outerHeight(0);
                gcBase.gcThumbsArea.addClass('gc-hide');
                gcBase.config.isKeypressEnabled = false;
            }
            else {
                gcBase.config.isOneThumbShown = true;
                gcBase.setupThumbs();
            }
            // OVERLAY: Setting centered position for NAVIGATION BUTTONS: previous/next
            if (gcBase.gcTotalThumbsImg == 1) {
                gcBase.gcOverlayPrevious.addClass('gc-hide');
                gcBase.gcOverlayNext.addClass('gc-hide');
            }
            else {
                gcBase.gcOverlayPrevious.css('margin-top', -(gcBase.gcOverlayPrevious.outerHeight() / 2));
                gcBase.gcOverlayNext.css('margin-top', -(gcBase.gcOverlayNext.outerHeight() / 2));
            }
            // COMPONENT
            if (gcBase.config.thumbsPosition == 'top' || gcBase.config.thumbsPosition == 'bottom') {
                var hThumbs = gcBase.config.isOneThumbShown == false ? 0 : gcBase.gcThumbsArea.outerHeight();
                gcBase.element.css({ 'height': hThumbs + gcBase.gcDisplayArea.outerHeight() + parseFloat(gcBase.config.thumbsMargin) });
            }
            else {
                var wThumbs = gcBase.config.isOneThumbShown == false ? 0 : gcBase.gcThumbsArea.outerWidth();
                gcBase.element.css({ 'width': wThumbs + gcBase.gcDisplayArea.outerWidth() + parseFloat(gcBase.config.thumbsMargin) });
                gcBase.element.css({ 'height': gcBase.gcDisplayArea.outerHeight() });
            }
        },
        setupDisplayArea: function () {
            var gcBase = this;

            var currentDisplayAreaWidth, currentDisplayAreaHeight,
                nextDisplayAreaWidth, nextDisplayAreaHeight,
                asWidth = gcBase.config.widthDisplay, asHeight = gcBase.config.heightDisplay;

            gcBase.gcDisplayArea.css({ 'height': '0', 'width': '0' });

            nextDisplayAreaWidth = gcBase.widthDisplayPerc * gcBase.element.outerWidth() / 100;

            nextDisplayAreaHeight = nextDisplayAreaWidth * (asHeight / asWidth);

            gcBase.gcDisplayArea.css({ 'height': Math.ceil(nextDisplayAreaHeight), 'width': Math.ceil(nextDisplayAreaWidth) });

            // Display: Setting centered position for NAVIGATION BUTTONS: previous/next
            gcBase.gcDisplayPrevious.css('margin-top', -(gcBase.gcDisplayPrevious.outerHeight() / 2));
            gcBase.gcDisplayNext.css('margin-top', -(gcBase.gcDisplayNext.outerHeight() / 2));

            if (gcBase.gcTotalThumbsImg == 1) {
                gcBase.gcDisplayPrevious.addClass('gc-hide');
                gcBase.gcDisplayNext.addClass('gc-hide');
            }
            gcBase.gcDisplayContainer.addClass('gc-hide');
            gcBase.addLoader(gcBase.gcDisplayArea);
        },
        setupDisplayDisplay: function () {
            var gcBase = this;

            gcBase.gcDisplayContainer.css({ 'width': '0', 'height': '0' });

            gcBase.gcDisplayContainer.css({ 'width': gcBase.gcDisplayArea.outerWidth(), 'height': gcBase.gcDisplayArea.outerHeight() });

            var widthRatio = gcBase.gcDisplayContainer.outerWidth() / gcBase.gcImageData[gcBase.current].width,
                heightRatio = gcBase.gcDisplayContainer.outerHeight() / gcBase.gcImageData[gcBase.current].height,
                ratio, ddWidth, ddHeight;

            if ((widthRatio < 1 || heightRatio < 1)) {
                gcBase.config.isZoomEnabled === true ? gcBase.isMouseEventsOn = true : gcBase.isMouseEventsOn = false;

                widthRatio < heightRatio ? ratio = widthRatio : ratio = heightRatio;

                ddWidth = ratio * gcBase.gcImageData[gcBase.current].width;
                ddHeight = ratio * gcBase.gcImageData[gcBase.current].height;
            }
            else { // In case that the image's width and height are smaller than the container's windth and height
                gcBase.gcDisplayContainer.trigger('mouseleave.glasscase');
                gcBase.isMouseEventsOn = false;

                ddWidth = gcBase.gcImageData[gcBase.current].width;
                ddHeight = gcBase.gcImageData[gcBase.current].height;
            }
            gcBase.gcDisplayDisplay.css({ 'width': ddWidth, 'height': ddHeight });
            gcBase.gcDisplayContainer.css({ 'width': ddWidth, 'height': ddHeight });

            // Positioning the container in the center of DisplayArea
            var borderVal = parseFloat(gcBase.gcDisplayArea.css('border-left-width')) * 2,
                paddingVal = parseFloat(gcBase.gcDisplayArea.css('padding-top')) * 2;

            var percMarginLeft = ((gcBase.gcDisplayContainer.outerWidth() / 2) * 100) / (gcBase.gcDisplayArea.outerWidth() - borderVal - paddingVal),
                percMarginTop = ((gcBase.gcDisplayContainer.outerHeight() / 2) * 100) / (gcBase.gcDisplayArea.outerWidth() - borderVal - paddingVal);

            gcBase.gcDisplayContainer.css({
                'margin-left': "-" + percMarginLeft + "%",
                'margin-top': "-" + percMarginTop + "%"
            });
        },
        setupZoom: function () {
            var gcBase = this;

            gcBase.gcZoomDisplay.attr('src', gcBase.gcDisplayDisplay.attr('src'))
                                .attr('alt', gcBase.gcDisplayDisplay.attr('alt'));
            if (gcBase.config.zoomPosition != 'inner') {
                gcBase.isAutoInnerZooming = false;
                gcBase.config = $.extend(true, {}, gcBase._defaults, gcBase._options);
                gcBase.gcZoom.appendTo(gcBase.element).removeClass('gc-zoom-inner');
            }

            var borderVal = parseFloat(gcBase.gcZoom.css('border-left-width')) * 2,
                paddingVal = parseFloat(gcBase.gcDisplayArea.css('padding-top')) * 2,
                zoomWidth = (gcBase.config.zoomPosition == 'inner') ? paddingVal : (borderVal + paddingVal),
                zoomHeight = (gcBase.config.zoomPosition == 'inner') ? paddingVal : (borderVal + paddingVal);

            for (var i = 0; i < 2; i++) {
                if (gcBase.config.isZoomDiffWH && gcBase.config.zoomWidth > 0) {
                    zoomWidth += parseFloat(gcBase.config.zoomWidth) < gcBase.gcImageData[gcBase.current].width ?
                                 parseFloat(gcBase.config.zoomWidth) : gcBase.gcImageData[gcBase.current].width;
                } else { zoomWidth += gcBase.gcDisplayContainer.outerWidth(); }

                if (gcBase.config.isZoomDiffWH && gcBase.config.zoomHeight > 0) {
                    zoomHeight += parseFloat(gcBase.config.zoomHeight) < gcBase.gcImageData[gcBase.current].height ?
                                  parseFloat(gcBase.config.zoomHeight) : gcBase.gcImageData[gcBase.current].height;
                } else { zoomHeight += gcBase.gcDisplayContainer.outerHeight(); }

                if (gcBase.config.isZoomDiffWH == false) {
                    zoomWidth = zoomHeight;
                }

                if (gcBase.config.autoInnerZoom == true && gcBase.config.zoomPosition != 'inner') {
                    if (gcBase.element.outerWidth() + zoomWidth > $(window).width()) {
                        gcBase.isAutoInnerZooming = true;
                        gcBase.config.isZoomDiffWH = true; gcBase.config.zoomWidth = 0; gcBase.config.zoomHeight = 0;
                        if (i == 0) { zoomWidth = zoomHeight = paddingVal; }
                    } else { break; }
                } else { break; }
                if (gcBase.config.zoomPosition == 'inner') { break; }
            }

            gcBase.gcZoomContainer.css({ 'width': 0, 'height': 0 });
            gcBase.gcZoom.css({ 'width': zoomWidth, 'height': zoomHeight });
            gcBase.gcZoomContainer.css({ 'width': gcBase.gcZoom.outerWidth(), 'height': gcBase.gcZoom.outerHeight() });

            if (gcBase.config.isZCapEnabled === true) {
                var capTxt = $(gcBase.gcThumbsImg[gcBase.current]).data('gc-caption');
                capTxt === undefined ? gcBase.gcCaption.hide() : (gcBase.gcCaption.show(), gcBase.gcCaptionDisplay.empty().append(capTxt));
                var cssClass;

                if (gcBase.isAutoInnerZooming === true) {
                    if (gcBase.config.capZType === 'out') {
                        gcBase.gcCaption.removeClass('gc-caption-outtop gc-caption-outbottom');

                        cssClass = gcBase.config.capZPos === 'top' ? 'gc-caption-intop' : 'gc-caption-inbottom';
                        gcBase.gcCaption.addClass(cssClass);
                    }
                } else {
                    if ((gcBase.config.capZType === 'out') &&
                        (gcBase.gcCaption.hasClass('gc-caption-intop') || gcBase.gcCaption.hasClass('gc-caption-inbottom'))) {
                        gcBase.gcCaption.removeClass('gc-caption-intop gc-caption-inbottom');

                        cssClass = gcBase.config.capZPos === 'top' ? 'gc-caption-outtop' : 'gc-caption-outbottom';
                        gcBase.gcCaption.addClass(cssClass);
                    }
                }
            }
        },
        setupZoomPos: function () {
            var gcBase = this;

            if (gcBase.config.zoomPosition == 'inner' || gcBase.isAutoInnerZooming == true) {
                gcBase.gcZoom.appendTo(gcBase.gcDisplayContainer).addClass('gc-zoom-inner');
            }
            else {
                gcBase.gcZoom.appendTo(gcBase.element).removeClass('gc-zoom-inner');

                if (gcBase.config.zoomPosition == 'left') {
                    gcBase.gcZoom.css({ 'right': (gcBase.element.outerWidth(true)), 'margin-right': gcBase.config.zoomMargin + 'px' });
                }
                else {
                    gcBase.gcZoom.css({ 'left': (gcBase.element.outerWidth(true)), 'margin-left': gcBase.config.zoomMargin + 'px' });
                }

                var topZ = gcBase.config.zoomAlignment == 'displayArea' ? 0 : gcBase.gcDisplayContainer.position().top
                                                                             + parseFloat(gcBase.gcDisplayContainer.css('margin-top'))
                                                                             - parseFloat(gcBase.gcDisplayArea.css('padding-top'));

                if (gcBase.config.thumbsPosition == 'top') {
                    var topT = gcBase.gcThumbsArea.outerHeight() + parseFloat(gcBase.config.thumbsMargin);
                    gcBase.gcZoom.css({ 'top': topZ + topT });
                }
                else {
                    gcBase.gcZoom.css({ 'top': topZ });
                }
            }
        },
        setupLens: function () {
            var gcBase = this;

            var percZoomWidth = Math.round(gcBase.gcZoomContainer.outerWidth() / gcBase.gcImageData[gcBase.current].width * 100);
            var valueLensW = Math.round(gcBase.gcDisplayDisplay.outerWidth() * percZoomWidth / 100);

            var percZoomHeight = Math.round(gcBase.gcZoomContainer.outerHeight() / gcBase.gcImageData[gcBase.current].height * 100);
            var valueLensH = Math.round(gcBase.gcDisplayDisplay.outerHeight() * percZoomHeight / 100);

            gcBase.gcLens.css({ 'width': (valueLensW), 'height': (valueLensH) });
            gcBase.mousemoveHandler();
        },
        addLoader: function (obj) { //obj - the object that will contain the loader
            var gcBase = this;

            $(obj).prepend(gcBase.gcLoader.clone());
        },
        removeLoader: function (obj) {
            var gcBase = this;

            var loader = $(obj).find('.' + gcBase.gcLoadingClass);

            if (loader.length) {
                loader.remove();
            }
        },
        setupThumbImg: function (obj, index) { // obj - li element
            var gcBase = this;

            var widthImg = gcBase.gcThumbsLi.outerWidth(),
                heightImg = gcBase.gcThumbsLi.outerHeight(),
                ratioImg, listItem = $(obj),
                wRatio = widthImg / gcBase.gcImageData[index].width,
    		    hRatio = heightImg / gcBase.gcImageData[index].height;

            ratioImg = wRatio > hRatio ? wRatio : hRatio;

            gcBase.gcThumbsImg[index].width = Math.ceil(gcBase.gcImageData[index].width * ratioImg, 10);
            gcBase.gcThumbsImg[index].height = Math.ceil(gcBase.gcImageData[index].height * ratioImg, 10);

            var percMarginLeft = ((gcBase.gcThumbsImg.eq(index).outerWidth() / 2) * 100) / (gcBase.gcThumbsLiDiv.outerWidth()),
                percMarginTop = ((gcBase.gcThumbsImg.eq(index).outerHeight() / 2) * 100) / (gcBase.gcThumbsLiDiv.outerWidth());

            gcBase.gcThumbsImg.eq(index).css({
                'margin-top': "-" + percMarginTop + "%",
                'margin-left': "-" + percMarginLeft + "%"
            });
            gcBase.gcThumbsLiDiv.eq(index).removeClass('gc-hide');
            gcBase.removeLoader(gcBase.gcThumbsLi.eq(index));
            gcBase.gcThumbsLiDiv.eq(index).removeClass('gc-hide');
            gcBase.removeLoader(gcBase.gcThumbsLi.eq(index));
        },
        setupThumbs: function () {
            var gcBase = this;

            if (gcBase.config.thumbsPosition == 'right') {
                gcBase.setupThumbsLR();
                gcBase.gcDisplayArea.css({ 'top': '0', 'left': '0' });
                gcBase.gcThumbsArea.css({ 'top': '0', 'left': gcBase.gcDisplayArea.outerWidth() + parseFloat(gcBase.config.thumbsMargin) });
            }
            if (gcBase.config.thumbsPosition == 'left') {
                gcBase.setupThumbsLR();
                gcBase.gcThumbsArea.css({ 'top': '0', 'left': '0' });
                gcBase.gcDisplayArea.css({ 'top': '0', 'left': gcBase.gcThumbsArea.outerWidth() + parseFloat(gcBase.config.thumbsMargin) });
            }
            if (gcBase.config.thumbsPosition == 'bottom') {
                gcBase.setupThumbsTB();
                gcBase.gcDisplayArea.css({ 'top': '0', 'left': '0' });
                gcBase.gcThumbsArea.css({ 'top': gcBase.gcDisplayArea.outerHeight() + parseFloat(gcBase.config.thumbsMargin), 'left': '0' });
            }
            if (gcBase.config.thumbsPosition == 'top') {
                gcBase.setupThumbsTB();
                gcBase.gcThumbsArea.css({ 'top': '0', 'left': '0' });
                gcBase.gcDisplayArea.css({ 'top': gcBase.gcThumbsArea.outerHeight() + parseFloat(gcBase.config.thumbsMargin), 'left': '0' });
            }
        },
        setupThumbsTB: function () {
            var gcBase = this;
            gcBase.gcThumbsArea.css('width', gcBase.gcDisplayArea.outerWidth());

            var liMarginRight = parseFloat(gcBase.gcThumbsLi.css('margin-right')),
                ratio = gcBase.config.widthDisplay / gcBase.config.heightDisplay,
                widthLi = (gcBase.gcThumbsArea.outerWidth() / gcBase.config.nrThumbsPerRow - (gcBase.config.nrThumbsPerRow - 1) * liMarginRight / gcBase.config.nrThumbsPerRow),
                heightLi = widthLi / ratio, widthLiPerc;
            if (gcBase.config.isThumbsOneRow == true) {
                widthLiPerc = (widthLi * 100) / (((widthLi + liMarginRight) * gcBase.gcThumbsLi.length) - liMarginRight);
            }
            else {
                widthLiPerc = (widthLi * 100) / gcBase.gcThumbsArea.outerWidth();
            }
            gcBase.gcThumbsLi.css({ 'width': widthLiPerc + "%", 'height': heightLi });
            gcBase.gcThumbsLiDiv.addClass('gc-hide');
            for (var i = 0; i < gcBase.gcThumbsLi.length; i++) {
                gcBase.addLoader(gcBase.gcThumbsLi[i]);
            }
            if (gcBase.config.isThumbsOneRow == true) {
                gcBase.gcThumbsLi.last().css('margin-right', 0);
            }
            else {
                gcBase.gcThumbsUl.find(':nth-child(' + gcBase.config.nrThumbsPerRow + 'n)').css('margin-right', 0);
                gcBase.gcThumbsUl.find(':nth-child(n +' + (parseFloat(gcBase.config.nrThumbsPerRow) + 1) + ')').css('margin-top', liMarginRight + 'px');
            }
            if (gcBase.config.isThumbsOneRow == true) {
                gcBase.gcThumbsUl.css({
                    'width': Math.ceil((widthLi * gcBase.gcThumbsLi.length + (gcBase.gcThumbsLi.length - 1) * liMarginRight)),
                    'height': Math.ceil(heightLi)
                });
                gcBase.gcThumbsArea.css('height', Math.ceil(heightLi));
            }
            else {
                var totalRows = Math.ceil((gcBase.gcThumbsLi.length) / gcBase.config.nrThumbsPerRow);
                var lHeight = Math.ceil(heightLi * totalRows + liMarginRight * (totalRows - 1));

                gcBase.gcThumbsUl.css({ 'width': gcBase.gcThumbsArea.outerWidth(), 'height': lHeight });
                gcBase.gcThumbsArea.css('height', lHeight);
            }
            if (gcBase.config.isThumbsOneRow == true) {
                gcBase.gcThumbsAreaPrevious.removeClass('gc-hide');
                gcBase.gcThumbsPrevious.css('margin-top', (-gcBase.gcThumbsPrevious.outerHeight() / 2));
                gcBase.gcThumbsAreaNext.removeClass('gc-hide');
                gcBase.gcThumbsNext.css('margin-top', (-gcBase.gcThumbsNext.outerHeight() / 2));

                gcBase.setupSlider();
            }
            else {
                gcBase.gcThumbsAreaPrevious.addClass('gc-hide');
                gcBase.gcThumbsAreaNext.addClass('gc-hide');
            }
            if (gcBase.iOS) {
                var brwLiWidth = gcBase.gcThumbsLi.outerWidth(), brwDiff = gcBase.gcThumbsArea.outerWidth() - (brwLiWidth * gcBase.config.nrThumbsPerRow + (gcBase.config.nrThumbsPerRow - 1) * liMarginRight);
                gcBase.gcThumbsUl.find(':nth-child(' + gcBase.config.nrThumbsPerRow + 'n)').css('width', brwLiWidth + brwDiff);
            }
        },
        setupThumbsLR: function () {
            var gcBase = this;
            gcBase.gcThumbsArea.css('height', gcBase.gcDisplayArea.outerHeight());

            var liMargin = parseFloat(gcBase.gcThumbsLi.css('margin-bottom')),
                ratio = gcBase.config.widthDisplay / gcBase.config.heightDisplay,
                heightLi = (gcBase.gcThumbsArea.outerHeight() / gcBase.config.nrThumbsPerRow - (gcBase.config.nrThumbsPerRow - 1) * liMargin / gcBase.config.nrThumbsPerRow),
                widthLi = heightLi * ratio, heightLiPerc;
            heightLiPerc = (heightLi * 100) / (((heightLi + liMargin) * gcBase.gcThumbsLi.length) - liMargin);
            gcBase.gcThumbsLi.css({ 'width': widthLi, 'height': heightLiPerc + "%" });
            gcBase.gcThumbsLiDiv.addClass('gc-hide');
            for (var i = 0; i < gcBase.gcThumbsLi.length; i++) {
                gcBase.addLoader(gcBase.gcThumbsLi[i]);
            }
            gcBase.gcThumbsLi.last().css('margin-bottom', 0);
            gcBase.gcThumbsUl.css({
                'width': Math.ceil(widthLi),
                'height': Math.ceil((((heightLi + liMargin) * gcBase.gcThumbsLi.length) - liMargin))
            });
            gcBase.gcThumbsArea.css('width', Math.ceil(widthLi));
            gcBase.gcThumbsAreaPrevious.removeClass('gc-hide');
            gcBase.gcThumbsPrevious.css('margin-left', (-gcBase.gcThumbsPrevious.outerWidth() / 2));
            gcBase.gcThumbsAreaNext.removeClass('gc-hide');
            gcBase.gcThumbsNext.css('margin-left', (-gcBase.gcThumbsNext.outerWidth() / 2));

            gcBase.setupSlider();
            if (gcBase.iOS) {
                var brwLiHeight = gcBase.gcThumbsLi.outerHeight();
                var brwDiff = gcBase.gcThumbsArea.outerHeight() - (brwLiHeight * gcBase.config.nrThumbsPerRow + (gcBase.config.nrThumbsPerRow - 1) * liMargin);
                gcBase.gcThumbsUl.find(':nth-child(' + gcBase.config.nrThumbsPerRow + 'n)').css('height', brwLiHeight + brwDiff);
            }
        },
        setupSlider: function () {
            var gcBase = this;

            if (gcBase.gcTotalThumbsImg <= gcBase.config.nrThumbsPerRow) {
                gcBase.gcThumbsAreaPrevious.addClass('gc-hide');
                gcBase.gcThumbsAreaNext.addClass('gc-hide');
                return;
            }
            gcBase.gcThumbsAreaPrevious.removeClass('gc-disabled');
            gcBase.gcThumbsAreaNext.removeClass('gc-disabled');

            if (gcBase.currentSlide == 0) {
                gcBase.gcThumbsAreaPrevious.addClass('gc-disabled');
            }
            if (gcBase.currentSlide == Math.floor((gcBase.gcThumbsLi.length - 1) / gcBase.config.nrThumbsPerRow)) {
                gcBase.gcThumbsAreaNext.addClass('gc-disabled');
            }
        },
        update: function () {
            var gcBase = this;
            var altTxt;
            //1.
            if (gcBase.config.colorActiveThumb != -1) {
                gcBase.element.find('.gc-active').css('border-color', "");
            }

            gcBase.gcThumbsLi.removeClass('gc-active').eq(gcBase.current).addClass('gc-active');

            if (gcBase.config.colorActiveThumb != -1) {
                gcBase.element.find('.gc-active').css('border-color', gcBase.config.colorActiveThumb);
            }

            //2.
            altTxt = gcBase.gcThumbsLi.eq(gcBase.current).find('img').attr('alt');
            if (altTxt === undefined) altTxt = 'image';

            gcBase.gcDisplayDisplay.attr('src', gcBase.gcThumbsLi.eq(gcBase.current).find('img').attr('src'))
                                   .attr('alt', altTxt);

            //3.
            gcBase.setupDisplayDisplay();
            gcBase.setupZoom();
            gcBase.setupLens();
            gcBase.setupZoomPos();
        },
        animateImage: function () {
            var gcBase = this;

            gcBase.gcDisplayDisplay.stop(true).animate({ opacity: 0.5 }, 200, function () {
                if ($('body').hasClass('gc-noscroll')) { // If OverlayArea is shown
                    gcBase.gcOverlayDisplay.animate({ opacity: 0 }, 200, function () {
                        gcBase.update();
                        gcBase.setupOverlay();
                        gcBase.gcOverlayDisplay.animate({ opacity: 1 }, 500);
                    });
                }

                if (!$('body').hasClass('gc-noscroll')) {
                    gcBase.update();
                }
                gcBase.gcDisplayDisplay.animate({ opacity: 1 }, 500, function () {
                    gcBase.gcZoomDisplay.attr('src', gcBase.gcDisplayDisplay.attr('src'))
                                        .attr('alt', gcBase.gcDisplayDisplay.attr('alt'));
                });
            });
        },
        nextImage: function () {
            var gcBase = this;

            gcBase.old = gcBase.current;
            gcBase.current = (gcBase.current == (gcBase.gcThumbsLi.length - 1)) ? 0 : gcBase.current + 1;
            gcBase.slide('true', '');
            gcBase.animateImage();
        },
        previousImage: function () {
            var gcBase = this;

            gcBase.old = gcBase.current;
            gcBase.current = (gcBase.current == 0) ? (gcBase.gcThumbsLi.length - 1) : gcBase.current - 1;
            gcBase.slide('true', '');
            gcBase.animateImage();
        },
        slide: function (isImageChange, slideChange) {//isImageChange: true || false; slideChange:   previous || next
            var gcBase = this;

            if (gcBase.config.isThumbsOneRow == false && (gcBase.config.thumbsPosition == 'bottom' || gcBase.config.thumbsPosition == 'top')) {
                return;
            }

            var nextSlide = 0;

            if (isImageChange == 'true') {
                nextSlide = Math.floor(gcBase.current / gcBase.config.nrThumbsPerRow);
            }
            else {
                if (slideChange == 'previous') {
                    nextSlide = 0;

                    if (gcBase.currentSlide > 0) {
                        nextSlide = gcBase.currentSlide - 1;
                    }
                }
                else {
                    nextSlide = Math.floor((gcBase.gcThumbsLi.length - 1) / gcBase.config.nrThumbsPerRow);

                    if (gcBase.currentSlide < nextSlide) {
                        nextSlide = gcBase.currentSlide + 1;
                    }
                }
            }

            if (nextSlide == gcBase.currentSlide)
                return;

            gcBase.currentSlide = nextSlide;

            var vMargin;
            //Making the slide
            if (gcBase.config.thumbsPosition == 'bottom' || gcBase.config.thumbsPosition == 'top') {
                vMargin = gcBase.gcThumbsArea.outerWidth() + parseFloat(gcBase.gcThumbsLi.css('margin-right'));
                gcBase.gcThumbsUl.animate({ left: (-(nextSlide * vMargin)) + 'px' }, gcBase.config.speed);
            } else {
                vMargin = gcBase.gcThumbsArea.outerHeight() + parseFloat(gcBase.gcThumbsLi.css('margin-bottom'));
                gcBase.gcThumbsUl.animate({ top: (-(nextSlide * vMargin)) + 'px' }, gcBase.config.speed);
            }
            var transitionendfn = $.proxy(function () {
                this.isAnimating = false;

                this.setupSlider();
            }, gcBase);

            transitionendfn.call();
        },
        mousemoveHandler: function (event) {
            var gcBase = this;

            if (event !== undefined) {
                if (gcBase.isTouchMove == true) {
                    if (event.originalEvent.touches.length == 1) {
                        var touch = event.originalEvent.touches[0];
                        gcBase.currentMousePos.x = touch.pageX;
                        gcBase.currentMousePos.y = touch.pageY;
                    }
                }
                else {
                    gcBase.currentMousePos.x = event.pageX;
                    gcBase.currentMousePos.y = event.pageY;
                }
            }

            if (gcBase.currentMousePos.x == -1 && gcBase.currentMousePos.y == -1) {
                return;
            }

            gcBase.calcMousePos(gcBase.currentMousePos);

            if ((gcBase.config.isSlowZoom == false) || (gcBase.config.isSlowZoom == true && event == undefined)) {
                gcBase.gcZoomDisplay.css({ 'top': gcBase.newZoom.top, 'left': gcBase.newZoom.left });
            }

            if ((gcBase.config.isSlowLens == false) || (gcBase.config.isSlowLens == true && event == undefined)) {
                gcBase.gcLens.css({ 'top': gcBase.newLens.top, 'left': gcBase.newLens.left });
            }
        },
        mouseenterHandler: function (event, oEventTrigger) {
            var gcBase = this;

            if (gcBase.isMouseEventsOn === false) return;

            if (oEventTrigger !== undefined) event = oEventTrigger;

            if (event !== undefined) {
                if (gcBase.isTouchMove === true) {
                    if (event.originalEvent.touches.length == 1) {
                        var touch = event.originalEvent.touches[0];
                        gcBase.currentMousePos.x = touch.pageX;
                        gcBase.currentMousePos.y = touch.pageY;
                    }
                }
                else {
                    gcBase.currentMousePos.x = event.pageX;
                    gcBase.currentMousePos.y = event.pageY;
                }
            }

            gcBase.calcMousePos(gcBase.currentMousePos);

            gcBase.currentZoom.top = gcBase.newZoom.top; gcBase.currentZoom.left = gcBase.newZoom.left;
            gcBase.currentLens.top = gcBase.newLens.top; gcBase.currentLens.left = gcBase.newLens.left;

            gcBase.gcZoomDisplay.css({ 'top': gcBase.newZoom.top, 'left': gcBase.newZoom.left });
            gcBase.gcLens.css({ 'top': gcBase.newLens.top, 'left': gcBase.newLens.left });

            if (gcBase.zooming == false) {
                if (gcBase.config.zoomPosition == 'inner' || gcBase.isAutoInnerZooming == true) {
                    gcBase.gcZoom.fadeIn(gcBase.config.speed);
                } else {
                    gcBase.gcLens.fadeIn(gcBase.config.speed);
                    gcBase.gcZoom.fadeIn(gcBase.config.speed);
                }
            }

            if (gcBase.config.isSlowZoom == true) {
                clearTimeout(gcBase.slowZoomTimer);
                gcBase.zoomSlowDown();
            }

            if (gcBase.config.isSlowLens == true) {
                clearTimeout(gcBase.slowLensTimer);
                gcBase.lensSlowDown();
            }

            gcBase.zooming = true;
        },
        mouseleaveHandler: function (event) {
            var gcBase = this;

            gcBase.gcLens.stop()
                         .hide();
            gcBase.gcZoom.stop()
                         .fadeOut(gcBase.config.speed);

            if (event !== undefined) {
                if (gcBase.isTouchMove == true) {
                    if (event.originalEvent.touches.length == 1) {
                        var touch = event.originalEvent.touches[0];
                        gcBase.currentMousePos.x = touch.pageX;
                        gcBase.currentMousePos.y = touch.pageY;
                    }
                }
                else {
                    gcBase.currentMousePos.x = event.pageX;
                    gcBase.currentMousePos.y = event.pageY;
                }
            }

            if (gcBase.config.isSlowZoom == true) {
                clearTimeout(gcBase.slowZoomTimer);
            }

            if (gcBase.config.isSlowLens == true) {
                clearTimeout(gcBase.slowLensTimer);
            }
            gcBase.zooming = false;
        },
        touchstartDC: function (event) {
            event.preventDefault();
        },
        touchmoveDC: function (event) {
            var gcBase = this;

            if (gcBase.isTouchMove == false) {
                gcBase.isTouchMove = true;
                gcBase.gcDisplayContainer.trigger('mouseenter.glasscase', event);
            }
            gcBase.mousemoveHandler(event);
            event.preventDefault();
        },
        touchendDC: function (event) {
            var gcBase = this;

            if (gcBase.isTouchMove == true) {
                gcBase.mouseleaveHandler(event);
                gcBase.isTouchMove = false;
            }
            else { gcBase.toggleOverlay(); }
            event.preventDefault();
        },
        calcMousePos: function (currentMousePos) {
            var gcBase = this;

            var imageContainerOffset = gcBase.gcDisplayContainer.offset();
            var mouseXRelative = gcBase.currentMousePos.x - imageContainerOffset.left,
                mouseYRelative = gcBase.currentMousePos.y - imageContainerOffset.top;

            var imageDisplayWidth = gcBase.gcDisplayDisplay.outerWidth(),
                imageDisplayHeight = gcBase.gcDisplayDisplay.outerHeight();

            var lensWidth = gcBase.gcLens.outerWidth(),
                lensHeight = gcBase.gcLens.outerHeight(),
                lensTop = mouseYRelative - Math.round(lensHeight / 2),
                lensLeft = mouseXRelative - Math.round(lensWidth / 2); // 2 -> the middle

            var ratio = gcBase.gcImageData[gcBase.current].width / imageDisplayWidth,
                zoomTop = -lensTop * ratio, zoomLeft = -lensLeft * ratio;

            if (mouseYRelative - lensHeight / 2 < 0) {
                lensTop = 0; zoomTop = 0;
            }

            if (mouseYRelative + lensHeight / 2 > 0 + imageDisplayHeight) {
                lensTop = imageDisplayHeight - lensHeight;

                zoomTop = -(gcBase.gcImageData[gcBase.current].height - gcBase.gcZoom.outerHeight());
            }

            if (mouseXRelative - lensWidth / 2 < 0) {
                lensLeft = 0;
                zoomLeft = 0;
            }

            if (mouseXRelative + lensWidth / 2 > 0 + imageDisplayWidth) {
                lensLeft = imageDisplayWidth - lensWidth;

                zoomLeft = -(gcBase.gcImageData[gcBase.current].width - gcBase.gcZoom.outerWidth());
            }

            gcBase.newZoom.left = zoomLeft;
            gcBase.newZoom.top = zoomTop;

            gcBase.newLens.left = lensLeft;
            gcBase.newLens.top = lensTop;
        },
        zoomSlowDown: function () {
            var gcBase = this;

            var diffZoomPos = { left: 0, top: 0 },
                moveZoomPos = { left: 0, top: 0 };

            //1. 
            diffZoomPos.left = gcBase.newZoom.left - gcBase.currentZoom.left;
            diffZoomPos.top = gcBase.newZoom.top - gcBase.currentZoom.top;

            //2.
            moveZoomPos.left = -diffZoomPos.left / (gcBase.config.speedSlowZoom / 100);
            moveZoomPos.top = -diffZoomPos.top / (gcBase.config.speedSlowZoom / 100);

            //3.
            gcBase.currentZoom.left = gcBase.currentZoom.left - moveZoomPos.left;
            gcBase.currentZoom.top = gcBase.currentZoom.top - moveZoomPos.top;

            //4.
            if (diffZoomPos.left < 1 && diffZoomPos.left > -1) {
                gcBase.currentZoom.left = gcBase.newZoom.left;
            }
            if (diffZoomPos.top < 1 && diffZoomPos.top > -1) {
                gcBase.currentZoom.top = gcBase.newZoom.top;
            }

            //5.
            gcBase.gcZoomDisplay.css({ 'top': gcBase.currentZoom.top, 'left': gcBase.currentZoom.left });

            gcBase.slowZoomTimer = setTimeout(function () { gcBase.zoomSlowDown(); }, 25);
        },
        lensSlowDown: function () {
            var gcBase = this;

            var diffLensPos = { left: 0, top: 0 },
                moveLensPos = { left: 0, top: 0 };

            //1.
            diffLensPos.left = gcBase.newLens.left - gcBase.currentLens.left;
            diffLensPos.top = gcBase.newLens.top - gcBase.currentLens.top;

            //2.
            moveLensPos.left = -diffLensPos.left / (gcBase.config.speedSlowLens / 100);
            moveLensPos.top = -diffLensPos.top / (gcBase.config.speedSlowLens / 100);

            //3.
            gcBase.currentLens.left = gcBase.currentLens.left - moveLensPos.left;
            gcBase.currentLens.top = gcBase.currentLens.top - moveLensPos.top;

            //4.
            if (diffLensPos.left < 1 && diffLensPos.left > -1) {
                gcBase.currentLens.left = gcBase.newLens.left;
            }
            if (diffLensPos.top < 1 && diffLensPos.top > -1) {
                gcBase.currentLens.top = gcBase.newLens.top;
            }

            //5.
            gcBase.gcLens.css('top', gcBase.currentLens.top);
            gcBase.gcLens.css('left', gcBase.currentLens.left);

            gcBase.slowLensTimer = setTimeout(function () { gcBase.lensSlowDown(); }, 25);
        },
        setupOverlay: function () {
            var gcBase = this;

            var isNatSizeSMScr = ((gcBase.gcImageData[gcBase.current].width <= gcBase.gcOverlayArea.outerWidth()) &&
                                  (gcBase.gcImageData[gcBase.current].height <= gcBase.gcOverlayArea.outerHeight()));

            gcBase.gcOverlayDisplay.attr('src', gcBase.gcDisplayDisplay.attr('src'))
                                   .attr('alt', gcBase.gcDisplayDisplay.attr('alt'));

            if (isNatSizeSMScr || (gcBase.config.isOverlayFullImage == true)) {

                gcBase.gcOverlayCompress.hide();
                gcBase.gcOverlayEnlarge.hide();
                gcBase.overlayNatSizes();
            }
            else {
                gcBase.gcOverlayCompress.hide();
                gcBase.gcOverlayEnlarge.show();
                gcBase.gcOverlayArea.removeClass('gc-natsize');
                gcBase.overlayFitSizes();
            }
        },
        overlayNatSizes: function () {
            var gcBase = this;
            var hOC = gcBase.gcOverlayContainer.outerHeight();
            var wOC = gcBase.gcOverlayContainer.outerWidth();

            gcBase.gcOverlayGContainer.removeClass('gc-overlay-fit');
            gcBase.gcOverlayDisplay.removeClass('gc-overlay-display-center gc-overlay-display-hcenter gc-overlay-display-vcenter');

            if (gcBase.gcImageData[gcBase.current].height <= hOC &&
                gcBase.gcImageData[gcBase.current].width <= wOC) {
                gcBase.gcOverlayDisplay.addClass('gc-overlay-display-center');
            } else {
                if (gcBase.gcImageData[gcBase.current].height <= hOC) {
                    gcBase.gcOverlayDisplay.addClass('gc-overlay-display-vcenter');
                }
                if (gcBase.gcImageData[gcBase.current].width <= wOC) {
                    gcBase.gcOverlayDisplay.addClass('gc-overlay-display-hcenter');
                }
            }
        },
        overlayFitSizes: function () {
            var gcBase = this;

            gcBase.gcOverlayGContainer.addClass('gc-overlay-fit');
            gcBase.gcOverlayDisplay.removeClass('gc-overlay-display-hcenter gc-overlay-display-vcenter')
                                   .addClass('gc-overlay-display-center');
        },
        toggleOverlayImgSize: function () {
            var gcBase = this;

            if (!gcBase.gcOverlayArea.hasClass('gc-natsize')) {
                gcBase.gcOverlayArea.addClass('gc-natsize');
                gcBase.gcOverlayEnlarge.hide();
                gcBase.gcOverlayCompress.show();
                gcBase.overlayNatSizes();
            }
            else {
                gcBase.gcOverlayEnlarge.show();
                gcBase.gcOverlayCompress.hide();
                gcBase.gcOverlayArea.removeClass('gc-natsize');
                gcBase.overlayFitSizes();
            }
        },
        toggleOverlay: function () {
            var gcBase = this;

            if ($('body').hasClass('gc-noscroll')) { //overlay on
                gcBase.fadeOutOverlay();
            }
            else {
                if (gcBase.config.isOverlayEnabled == false)
                    return;
                gcBase.gcOverlayArea.fadeIn(gcBase.config.speed);
                $('body').addClass('gc-noscroll');
                gcBase.setupOverlay();
            }
        },
        fadeOutOverlay: function () {
            var gcBase = this;

            $('body').removeClass('gc-noscroll');
            gcBase.gcOverlayArea.fadeOut(gcBase.config.speed);
        },
        resizeGC: function () {
            var gcBase = this;

            gcBase.element.css({ 'height': '0', 'width': '0' });
            gcBase.setup();
            gcBase.gcThumbsImg.each(function (index) {
                //2.
                gcBase.setupThumbImg(gcBase.gcThumbsLi.eq(index), index);

                //3.                            
                gcBase.removeLoader(gcBase.gcThumbsLi.eq(index));
                gcBase.gcThumbsLi.eq(index).find('.gc-li-display-container').removeClass('gc-hide');

                //4.
                if (gcBase.current == index) {
                    gcBase.removeLoader(gcBase.gcDisplayArea);
                    gcBase.gcDisplayContainer.removeClass('gc-hide');
                    gcBase.setupDisplayDisplay();
                    gcBase.setupLens();
                }
            });
            gcBase.update();

            if (!gcBase.config.isOverlayFullImage) {
                gcBase.setupOverlay();
            }
        },
        showDAIcons: function () {
            var gcBase = this;

            if (gcBase.gcTotalThumbsImg > 1) {
                gcBase.gcDisplayPrevious.show();
                gcBase.gcDisplayNext.show();
            }
            if (gcBase.config.isDownloadEnabled == true) { gcBase.gcDisplayDownload.show(); }
        },
        hideDAIcons: function () {
            var gcBase = this;

            if (gcBase.gcTotalThumbsImg > 1) {
                gcBase.gcDisplayPrevious.hide();
                gcBase.gcDisplayNext.hide();
            }
            if (gcBase.config.isDownloadEnabled == true) { gcBase.gcDisplayDownload.hide(); }
        },
        changeThumbs: function (index) {
            var gcBase = this;

            if (gcBase.current != index) {
                gcBase.old = gcBase.current;
                gcBase.current = index;
                gcBase.animateImage();
            }
        },
        initEvents: function () {
            var gcBase = this;
            //Display   
            if (gcBase.config.isZoomEnabled === true) {
                gcBase.isMouseEventsOn = true;
                gcBase.gcDisplayContainer.on('touchstart.glasscase', $.proxy(gcBase.touchstartDC, gcBase))
                                         .on('touchmove.glasscase', $.proxy(gcBase.touchmoveDC, gcBase))
                                         .on('touchend.glasscase', $.proxy(gcBase.touchendDC, gcBase));
                gcBase.gcDisplayContainer.on('mousemove.glasscase', $.proxy(gcBase.mousemoveHandler, gcBase))
                                         .on('mouseenter.glasscase', $.proxy(gcBase.mouseenterHandler, gcBase))
                                         .on('mouseenter.glasscase', $.proxy(gcBase.config.mouseEnterDisplayCB, gcBase))
                                         .on('mouseleave.glasscase', $.proxy(gcBase.mouseleaveHandler, gcBase))
                                         .on('mouseleave.glasscase', $.proxy(gcBase.config.mouseLeaveDisplayCB, gcBase));
            }

            if (gcBase.config.isShowAlwaysIcons != true) {
                gcBase.gcDisplayArea
                    .on('mouseenter.glasscaseDA', $.proxy(gcBase.showDAIcons, gcBase))
                    .on('mouseleave.glasscaseDA', $.proxy(gcBase.hideDAIcons, gcBase))
                    .on('mousemove.glasscaseDA', function (event) {
                        gcBase.showDAIcons();
                        clearTimeout(gcBase.mouseTimer);
                        gcBase.mouseTimer = setTimeout(function () { gcBase.hideDAIcons(); }, gcBase.config.speedHideIcons);
                    })
                    .on('touchmove.glasscaseDA', function (event) {
                        gcBase.showDAIcons();
                        clearTimeout(gcBase.mouseTimer);
                        gcBase.mouseTimer = setTimeout(function () { gcBase.hideDAIcons(); }, gcBase.config.speedHideIcons);
                        event.preventDefault();
                    });
            }

            gcBase.gcDisplayContainer.on('click.glasscase', function (event) {
                gcBase.toggleOverlay();
            });

            gcBase.gcDisplayDownload.on('click.glasscase', function (event) {
                var canvas = document.createElement('canvas');
                canvas.width = gcBase.gcImageData[gcBase.current].width;
                canvas.height = gcBase.gcImageData[gcBase.current].height;
                var context = canvas.getContext('2d');
                context.drawImage(gcBase.gcDisplayDisplay[0], 0, 0);
                var blob = new Blob();
                canvas.toBlob(function (blob) {
                    saveAs(
			                blob
			            , gcBase.gcDisplayDisplay.attr('src').replace(/^.*[\\\/]/, '')
		            );
                }, 'image/png');
            });
            gcBase.gcDisplayPrevious.on('click.glasscase', function (event) {
                gcBase.previousImage();
            });
            gcBase.gcDisplayNext.on('click.glasscase', function (event) {
                gcBase.nextImage();
            });
            //Overlay
            gcBase.gcOverlayPrevious.on('click.glasscase', function (event) {
                gcBase.previousImage();
            });
            gcBase.gcOverlayNext.on('click.glasscase', function (event) {
                gcBase.nextImage();
            });
            gcBase.gcOverlayClose.on('click.glasscase', function (event) {
                gcBase.toggleOverlay();
            });
            gcBase.gcOverlayContainer.on('click.glasscase', function (event) {
                gcBase.toggleOverlay();
            });
            gcBase.gcOverlayDisplay.on('mouseenter.glasscase', function (event) {
                gcBase.gcOverlayContainer.off('click.glasscase');
            });
            gcBase.gcOverlayDisplay.on('mouseleave.glasscase', function (event) {
                gcBase.gcOverlayContainer.on('click.glasscase', function (event) {
                    gcBase.toggleOverlay();
                });
            });
            if (!gcBase.config.isOverlayFullImage) {
                gcBase.gcOverlayDisplay.on('dblclick.glasscase', function (event) {
                    gcBase.toggleOverlayImgSize();
                });
                gcBase.gcOverlayEnlarge.on('click.glasscase', function (event) {
                    gcBase.toggleOverlayImgSize();
                });
                gcBase.gcOverlayCompress.on('click.glasscase', function (event) {
                    gcBase.toggleOverlayImgSize();
                });
            }
            //General
            $(document).on('keydown', function (event) {
                if (gcBase.config.isKeypressEnabled == true) {
                    if (event.keyCode == 37) { //<-
                        gcBase.previousImage();
                    }

                    if (event.keyCode == 39) {//->
                        gcBase.nextImage();
                    }
                }
                if (event.keyCode == 27) { //esc
                    gcBase.fadeOutOverlay();
                }
            });
            $(window).resize(function () {
                clearTimeout(gcBase.resizeTimer);
                gcBase.resizeTimer = setTimeout(function () { gcBase.resizeGC(); }, 100);
            });
            //Thumbs
            gcBase.gcThumbsLi.on('click.glasscase', function (event) {
                var idx = $(this).index(); gcBase.changeThumbs(idx);
            });
            if (gcBase.config.isHoverShowThumbs == true) {
                gcBase.gcThumbsLi.on('mouseenter', function (event) {
                    var idx = $(this).index(); gcBase.changeThumbs(idx);
                });
            }
            gcBase.gcThumbsAreaPrevious.on('click.glasscase', function (event) {
                gcBase.slide('false', 'previous');
            });
            gcBase.gcThumbsAreaNext.on('click.glasscase', function (event) {
                gcBase.slide('false', 'next');
            });
        }
    };

    //4. Attaching the plugin to the $ object
    $.fn.glassCase = function (options) {
        this.each(function () {
            var instance = $.data(this, 'gcglasscase');
            if (!instance) {
                $.data(this, 'gcglasscase', new GlassCase($(this), options));
            }
        });
    };

})(jQuery, window, document);