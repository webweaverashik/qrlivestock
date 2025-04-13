"use strict";

var KTServiceRecordCreate = function () {
     // Define shared variables
     var initAJAXFarmLoad = function () {

     };

     return {
          // Public functions  
          init: function () {
               initAJAXFarmLoad();
          }
     }
}();


// On document ready
KTUtil.onDOMContentLoaded(function () {
     KTServiceRecordCreate.init();
});