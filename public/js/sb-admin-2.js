/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/sb-admin-2.js":
/*!************************************!*\
  !*** ./resources/js/sb-admin-2.js ***!
  \************************************/
/***/ (() => {

eval("(function ($) {\n  \"use strict\"; // Start of use strict\n  // Toggle the side navigation\n\n  $(\"#sidebarToggle, #sidebarToggleTop\").on('click', function (e) {\n    $(\"body\").toggleClass(\"sidebar-toggled\");\n    $(\".sidebar\").toggleClass(\"toggled\");\n\n    if ($(\".sidebar\").hasClass(\"toggled\")) {\n      $('.sidebar .collapse').collapse('hide');\n    }\n\n    ;\n  }); // Close any open menu accordions when window is resized below 768px\n\n  $(window).resize(function () {\n    if ($(window).width() < 768) {\n      $('.sidebar .collapse').collapse('hide');\n    }\n\n    ; // Toggle the side navigation when window is resized below 480px\n\n    if ($(window).width() < 480 && !$(\".sidebar\").hasClass(\"toggled\")) {\n      $(\"body\").addClass(\"sidebar-toggled\");\n      $(\".sidebar\").addClass(\"toggled\");\n      $('.sidebar .collapse').collapse('hide');\n    }\n\n    ;\n  }); // Prevent the content wrapper from scrolling when the fixed side navigation hovered over\n\n  $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function (e) {\n    if ($(window).width() > 768) {\n      var e0 = e.originalEvent,\n          delta = e0.wheelDelta || -e0.detail;\n      this.scrollTop += (delta < 0 ? 1 : -1) * 30;\n      e.preventDefault();\n    }\n  }); // Scroll to top button appear\n\n  $(document).on('scroll', function () {\n    var scrollDistance = $(this).scrollTop();\n\n    if (scrollDistance > 100) {\n      $('.scroll-to-top').fadeIn();\n    } else {\n      $('.scroll-to-top').fadeOut();\n    }\n  }); // Smooth scrolling using jQuery easing\n\n  $(document).on('click', 'a.scroll-to-top', function (e) {\n    var $anchor = $(this);\n    $('html, body').stop().animate({\n      scrollTop: $($anchor.attr('href')).offset().top\n    }, 1000, 'easeInOutExpo');\n    e.preventDefault();\n  });\n})(jQuery); // End of use strict//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJuYW1lcyI6WyIkIiwib24iLCJlIiwidG9nZ2xlQ2xhc3MiLCJoYXNDbGFzcyIsImNvbGxhcHNlIiwid2luZG93IiwicmVzaXplIiwid2lkdGgiLCJhZGRDbGFzcyIsImUwIiwib3JpZ2luYWxFdmVudCIsImRlbHRhIiwid2hlZWxEZWx0YSIsImRldGFpbCIsInNjcm9sbFRvcCIsInByZXZlbnREZWZhdWx0IiwiZG9jdW1lbnQiLCJzY3JvbGxEaXN0YW5jZSIsImZhZGVJbiIsImZhZGVPdXQiLCIkYW5jaG9yIiwic3RvcCIsImFuaW1hdGUiLCJhdHRyIiwib2Zmc2V0IiwidG9wIiwialF1ZXJ5Il0sInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9qcy9zYi1hZG1pbi0yLmpzPzM1NDEiXSwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uKCQpIHtcbiAgXCJ1c2Ugc3RyaWN0XCI7IC8vIFN0YXJ0IG9mIHVzZSBzdHJpY3RcblxuICAvLyBUb2dnbGUgdGhlIHNpZGUgbmF2aWdhdGlvblxuICAkKFwiI3NpZGViYXJUb2dnbGUsICNzaWRlYmFyVG9nZ2xlVG9wXCIpLm9uKCdjbGljaycsIGZ1bmN0aW9uKGUpIHtcbiAgICAkKFwiYm9keVwiKS50b2dnbGVDbGFzcyhcInNpZGViYXItdG9nZ2xlZFwiKTtcbiAgICAkKFwiLnNpZGViYXJcIikudG9nZ2xlQ2xhc3MoXCJ0b2dnbGVkXCIpO1xuICAgIGlmICgkKFwiLnNpZGViYXJcIikuaGFzQ2xhc3MoXCJ0b2dnbGVkXCIpKSB7XG4gICAgICAkKCcuc2lkZWJhciAuY29sbGFwc2UnKS5jb2xsYXBzZSgnaGlkZScpO1xuICAgIH07XG4gIH0pO1xuXG4gIC8vIENsb3NlIGFueSBvcGVuIG1lbnUgYWNjb3JkaW9ucyB3aGVuIHdpbmRvdyBpcyByZXNpemVkIGJlbG93IDc2OHB4XG4gICQod2luZG93KS5yZXNpemUoZnVuY3Rpb24oKSB7XG4gICAgaWYgKCQod2luZG93KS53aWR0aCgpIDwgNzY4KSB7XG4gICAgICAkKCcuc2lkZWJhciAuY29sbGFwc2UnKS5jb2xsYXBzZSgnaGlkZScpO1xuICAgIH07XG4gICAgXG4gICAgLy8gVG9nZ2xlIHRoZSBzaWRlIG5hdmlnYXRpb24gd2hlbiB3aW5kb3cgaXMgcmVzaXplZCBiZWxvdyA0ODBweFxuICAgIGlmICgkKHdpbmRvdykud2lkdGgoKSA8IDQ4MCAmJiAhJChcIi5zaWRlYmFyXCIpLmhhc0NsYXNzKFwidG9nZ2xlZFwiKSkge1xuICAgICAgJChcImJvZHlcIikuYWRkQ2xhc3MoXCJzaWRlYmFyLXRvZ2dsZWRcIik7XG4gICAgICAkKFwiLnNpZGViYXJcIikuYWRkQ2xhc3MoXCJ0b2dnbGVkXCIpO1xuICAgICAgJCgnLnNpZGViYXIgLmNvbGxhcHNlJykuY29sbGFwc2UoJ2hpZGUnKTtcbiAgICB9O1xuICB9KTtcblxuICAvLyBQcmV2ZW50IHRoZSBjb250ZW50IHdyYXBwZXIgZnJvbSBzY3JvbGxpbmcgd2hlbiB0aGUgZml4ZWQgc2lkZSBuYXZpZ2F0aW9uIGhvdmVyZWQgb3ZlclxuICAkKCdib2R5LmZpeGVkLW5hdiAuc2lkZWJhcicpLm9uKCdtb3VzZXdoZWVsIERPTU1vdXNlU2Nyb2xsIHdoZWVsJywgZnVuY3Rpb24oZSkge1xuICAgIGlmICgkKHdpbmRvdykud2lkdGgoKSA+IDc2OCkge1xuICAgICAgdmFyIGUwID0gZS5vcmlnaW5hbEV2ZW50LFxuICAgICAgICBkZWx0YSA9IGUwLndoZWVsRGVsdGEgfHwgLWUwLmRldGFpbDtcbiAgICAgIHRoaXMuc2Nyb2xsVG9wICs9IChkZWx0YSA8IDAgPyAxIDogLTEpICogMzA7XG4gICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgfVxuICB9KTtcblxuICAvLyBTY3JvbGwgdG8gdG9wIGJ1dHRvbiBhcHBlYXJcbiAgJChkb2N1bWVudCkub24oJ3Njcm9sbCcsIGZ1bmN0aW9uKCkge1xuICAgIHZhciBzY3JvbGxEaXN0YW5jZSA9ICQodGhpcykuc2Nyb2xsVG9wKCk7XG4gICAgaWYgKHNjcm9sbERpc3RhbmNlID4gMTAwKSB7XG4gICAgICAkKCcuc2Nyb2xsLXRvLXRvcCcpLmZhZGVJbigpO1xuICAgIH0gZWxzZSB7XG4gICAgICAkKCcuc2Nyb2xsLXRvLXRvcCcpLmZhZGVPdXQoKTtcbiAgICB9XG4gIH0pO1xuXG4gIC8vIFNtb290aCBzY3JvbGxpbmcgdXNpbmcgalF1ZXJ5IGVhc2luZ1xuICAkKGRvY3VtZW50KS5vbignY2xpY2snLCAnYS5zY3JvbGwtdG8tdG9wJywgZnVuY3Rpb24oZSkge1xuICAgIHZhciAkYW5jaG9yID0gJCh0aGlzKTtcbiAgICAkKCdodG1sLCBib2R5Jykuc3RvcCgpLmFuaW1hdGUoe1xuICAgICAgc2Nyb2xsVG9wOiAoJCgkYW5jaG9yLmF0dHIoJ2hyZWYnKSkub2Zmc2V0KCkudG9wKVxuICAgIH0sIDEwMDAsICdlYXNlSW5PdXRFeHBvJyk7XG4gICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xuICB9KTtcblxufSkoalF1ZXJ5KTsgLy8gRW5kIG9mIHVzZSBzdHJpY3RcbiJdLCJtYXBwaW5ncyI6IkFBQUEsQ0FBQyxVQUFTQSxDQUFULEVBQVk7RUFDWCxhQURXLENBQ0c7RUFFZDs7RUFDQUEsQ0FBQyxDQUFDLG1DQUFELENBQUQsQ0FBdUNDLEVBQXZDLENBQTBDLE9BQTFDLEVBQW1ELFVBQVNDLENBQVQsRUFBWTtJQUM3REYsQ0FBQyxDQUFDLE1BQUQsQ0FBRCxDQUFVRyxXQUFWLENBQXNCLGlCQUF0QjtJQUNBSCxDQUFDLENBQUMsVUFBRCxDQUFELENBQWNHLFdBQWQsQ0FBMEIsU0FBMUI7O0lBQ0EsSUFBSUgsQ0FBQyxDQUFDLFVBQUQsQ0FBRCxDQUFjSSxRQUFkLENBQXVCLFNBQXZCLENBQUosRUFBdUM7TUFDckNKLENBQUMsQ0FBQyxvQkFBRCxDQUFELENBQXdCSyxRQUF4QixDQUFpQyxNQUFqQztJQUNEOztJQUFBO0VBQ0YsQ0FORCxFQUpXLENBWVg7O0VBQ0FMLENBQUMsQ0FBQ00sTUFBRCxDQUFELENBQVVDLE1BQVYsQ0FBaUIsWUFBVztJQUMxQixJQUFJUCxDQUFDLENBQUNNLE1BQUQsQ0FBRCxDQUFVRSxLQUFWLEtBQW9CLEdBQXhCLEVBQTZCO01BQzNCUixDQUFDLENBQUMsb0JBQUQsQ0FBRCxDQUF3QkssUUFBeEIsQ0FBaUMsTUFBakM7SUFDRDs7SUFBQSxDQUh5QixDQUsxQjs7SUFDQSxJQUFJTCxDQUFDLENBQUNNLE1BQUQsQ0FBRCxDQUFVRSxLQUFWLEtBQW9CLEdBQXBCLElBQTJCLENBQUNSLENBQUMsQ0FBQyxVQUFELENBQUQsQ0FBY0ksUUFBZCxDQUF1QixTQUF2QixDQUFoQyxFQUFtRTtNQUNqRUosQ0FBQyxDQUFDLE1BQUQsQ0FBRCxDQUFVUyxRQUFWLENBQW1CLGlCQUFuQjtNQUNBVCxDQUFDLENBQUMsVUFBRCxDQUFELENBQWNTLFFBQWQsQ0FBdUIsU0FBdkI7TUFDQVQsQ0FBQyxDQUFDLG9CQUFELENBQUQsQ0FBd0JLLFFBQXhCLENBQWlDLE1BQWpDO0lBQ0Q7O0lBQUE7RUFDRixDQVhELEVBYlcsQ0EwQlg7O0VBQ0FMLENBQUMsQ0FBQyx5QkFBRCxDQUFELENBQTZCQyxFQUE3QixDQUFnQyxpQ0FBaEMsRUFBbUUsVUFBU0MsQ0FBVCxFQUFZO0lBQzdFLElBQUlGLENBQUMsQ0FBQ00sTUFBRCxDQUFELENBQVVFLEtBQVYsS0FBb0IsR0FBeEIsRUFBNkI7TUFDM0IsSUFBSUUsRUFBRSxHQUFHUixDQUFDLENBQUNTLGFBQVg7TUFBQSxJQUNFQyxLQUFLLEdBQUdGLEVBQUUsQ0FBQ0csVUFBSCxJQUFpQixDQUFDSCxFQUFFLENBQUNJLE1BRC9CO01BRUEsS0FBS0MsU0FBTCxJQUFrQixDQUFDSCxLQUFLLEdBQUcsQ0FBUixHQUFZLENBQVosR0FBZ0IsQ0FBQyxDQUFsQixJQUF1QixFQUF6QztNQUNBVixDQUFDLENBQUNjLGNBQUY7SUFDRDtFQUNGLENBUEQsRUEzQlcsQ0FvQ1g7O0VBQ0FoQixDQUFDLENBQUNpQixRQUFELENBQUQsQ0FBWWhCLEVBQVosQ0FBZSxRQUFmLEVBQXlCLFlBQVc7SUFDbEMsSUFBSWlCLGNBQWMsR0FBR2xCLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUWUsU0FBUixFQUFyQjs7SUFDQSxJQUFJRyxjQUFjLEdBQUcsR0FBckIsRUFBMEI7TUFDeEJsQixDQUFDLENBQUMsZ0JBQUQsQ0FBRCxDQUFvQm1CLE1BQXBCO0lBQ0QsQ0FGRCxNQUVPO01BQ0xuQixDQUFDLENBQUMsZ0JBQUQsQ0FBRCxDQUFvQm9CLE9BQXBCO0lBQ0Q7RUFDRixDQVBELEVBckNXLENBOENYOztFQUNBcEIsQ0FBQyxDQUFDaUIsUUFBRCxDQUFELENBQVloQixFQUFaLENBQWUsT0FBZixFQUF3QixpQkFBeEIsRUFBMkMsVUFBU0MsQ0FBVCxFQUFZO0lBQ3JELElBQUltQixPQUFPLEdBQUdyQixDQUFDLENBQUMsSUFBRCxDQUFmO0lBQ0FBLENBQUMsQ0FBQyxZQUFELENBQUQsQ0FBZ0JzQixJQUFoQixHQUF1QkMsT0FBdkIsQ0FBK0I7TUFDN0JSLFNBQVMsRUFBR2YsQ0FBQyxDQUFDcUIsT0FBTyxDQUFDRyxJQUFSLENBQWEsTUFBYixDQUFELENBQUQsQ0FBd0JDLE1BQXhCLEdBQWlDQztJQURoQixDQUEvQixFQUVHLElBRkgsRUFFUyxlQUZUO0lBR0F4QixDQUFDLENBQUNjLGNBQUY7RUFDRCxDQU5EO0FBUUQsQ0F2REQsRUF1REdXLE1BdkRILEUsQ0F1RFkiLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvc2ItYWRtaW4tMi5qcy5qcyIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/sb-admin-2.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/sb-admin-2.js"]();
/******/ 	
/******/ })()
;