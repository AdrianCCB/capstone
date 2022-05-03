<?php 
include('core/config.php');
include('core/db.php');
include('core/functions.php');

if(isLoggedIn() == 0){
  header("Location: " . SITE_URL . "admin-login.php"); // if there are no cookies, redirect to login
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calendar</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
  <!-- Fullcalendar CSS -->
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
  <!-- Customs CSS -->
  <link rel="stylesheet" href="css/tooltip.css">
  <link rel="stylesheet" href="css/admin-page.css">

</head>

<body id="admin-bg">
  <div class="row  align-items-stretch d-flex">
      <!-- start of left side navbar -->
      <div class="col-lg-2 col-md-3 col-sm-3 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark"  style="height: 100vh;">
          <a href="admin.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
              <svg class="bi me-2" width="20" height="32">
                  <use xlink:href="#bootstrap" />
              </svg>
              <span class="fs-4">Admin Page</span>
          </a>
          <hr>
          <ul class="nav nav-pills flex-column mb-auto">
              <li class="nav-item">
                  <a href="admin.php" class="nav-link text-white" aria-current="page">
                      <svg class="bi me-2" width="8" height="16">
                          <use xlink:href="#home" />
                      </svg>
                      Home
                  </a>
              </li>
              <li>
                  <a href="admin-calendar.php" class="nav-link text-white active">
                      <svg class="bi me-2" width="8" height="16">
                          <use xlink:href="#table" />
                      </svg>
                      Calender
                  </a>
              </li>
              <li>
                  <a href="admin-customers.php" class="nav-link text-white">
                      <svg class="bi me-2" width="8" height="16">
                          <use xlink:href="#grid" />
                      </svg>
                      Customers
                  </a>
              </li>
              <li>
                  <a href="admin-logout.php" class="nav-link text-white">
                      <svg class="bi me-2" width="4" height="16">
                          <use xlink:href="#grid" />
                      </svg>
                      <button class="btn btn-light">Logout</button>
                  </a>
              </li>
          </ul>
      </div>
      <!-- end of left side navbar -->

      <!-- start of main content -->
      <div class="container-fluid col-lg-8 col-md-8 col-sm-8">
          <div id='calendar'></div>
      </div>
      <!-- end of main content -->
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <!-- jQuery JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <!-- Full Calendar JS -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
  <!-- <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script> -->
  <script src=" https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
  <script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script> 
  
  <!-- Sweetalert -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

  <script>

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // display viewing format
        contentHeight: 450, // adjusting the height of the calendar
        selectable: true, // cell is selectable
        editable: true, // is it editable
        themeSystem: 'bootstrap5', 
        // eventDisplay: 'list-item', // display the event in list format
        headerToolbar: {
          start: 'today prev,next', // left header
          center: 'title', // title = MM-YYYY
          right: 'dayGridMonth,listWeek' // month, week, list
        },
        bootstrapFontAwesome: {
          close: 'fa-times',
          prev: 'fa-chevron-left',
          next: 'fa-chevron-right',
          prevYear: 'fa-angle-double-left',
          nextYear: 'fa-angle-double-right'
        },
        
        eventDidMount: function(info) {
            $(info.el).tooltip({
                title: '<html>' + '<h3>' + info.event.extendedProps.service + '</h3>' +
                    '<b>' + 'Customer: ' + '</b>' + info.event.extendedProps.userName +
                    '<br>' +
                    '<b>' + 'Contact: ' + '</b>' + info.event.extendedProps.userPhone +
                    '</html>' + '<br>' +
                    '<b>' + 'Email: ' + '</b>' + info.event.extendedProps.userEmail +
                    '</html>',
                placement: 'top',
                html: true
            });
        },
        // eventDidMount: function(info) {
        //   var tooltip = new Tooltip(info.el, {
        //     title: '<html>' + '<h3>' + info.event.extendedProps.service + '</h3>' + '<b>' + 'Customer: ' + '</b>' + info.event.extendedProps.userName + '<br>' + 
        //           '<b>' + 'Contact: ' + '</b>' + info.event.extendedProps.userPhone + '</html>' + '<br>' + 
        //           '<b>' + 'Email: ' + '</b>' + info.event.extendedProps.userEmail + '</html>',
        //     placement: 'top',
        //     html: true,
        //     trigger: 'hover',
        //     container: 'body'
        //   });
        // },

        // loading all events from DB
        events: 'load.php',    
        // This hook allows you to receive arbitrary event data from a JSON feed 
        eventDataTransform: function(eventData) {
            return eventTransform(eventData);            
        },
        // Add events
        dateClick: function(info) { // Triggered when the user clicks on a date or a time
          var title = prompt("Enter Services");
          var artist = prompt("Enter Artist name");
          if(title) {
            var start = info.dateStr; // to extract only dateStr
            $.ajax({
              url:"insert.php",
              type:"POST",
              data:{
                title: title,
                start: start,
                artist: artist
              },
              success:function(){
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'New appointment added',
                  showConfirmButton: false,
                  timer: 1500
                }).then(function(){
                  calendar.refetchEvents();  // Refetches events from all sources and rerenders them on the screen.
                })
              }
            })
          }
        },
        // delete events
        eventClick:function(info){
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              var id = info.event._def.extendedProps.ID;
              var eventDetail = info.event._def.title;
            
              $.ajax({
                url:"delete.php",
                type:"POST",
                data:{
                  id: id
                },
                success:function(info){
                  if(data = "Delete"){
                    Swal.fire(
                        'Deleted',
                        'Appointment: " ' + eventDetail + '" has deleted',
                        'info'
                    ).then(function(){
                      calendar.refetchEvents();  // Refetches events from all sources and rerenders them on the screen.
                    })
                  }
                }
              })
            }
          })
        }, 
        // drag and drop event
        eventDrop:function(info) {
          var start = info.event.startStr;
          var title = info.event._def.title;
          var id = info.event._def.extendedProps.ID;
          var artist = info.event._def.extendedProps.artist;
          var dateAlert = new Date(start);
          var formattedDate = dateAlert.toLocaleString("en-GB", {
            day: "numeric",
            month: "short",
            year: "numeric"
          });
          
          console.log(artist)
          $.ajax({
            url:"update.php",
            type:"POST",
            data:{
              title: title, 
              start: start, 
              id: id,
              artist: artist
            },
            success:function(info){
              if(info == "success") {
                Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Changes Successful',
                showConfirmButton: false,
                timer: 1500
                }).then(function(){
                  calendar.refetchEvents();  // Refetches events from all sources and rerenders them on the screen.
                })
              } else {
                Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: artist + ' already has appointment on ' + formattedDate,
                showConfirmButton: true,
                timer: false
                }).then(function(){
                  calendar.refetchEvents();  // Refetches events from all sources and rerenders them on the screen.
                })
              }
              
            }
          });
        },       
      });
      calendar.render();
    });

    function eventTransform(eventData){
      if (eventData.artist == 'Adrian'){
        eventData.backgroundColor = 'red'; 
        eventData.title = eventData.title + ' by Adrian';
        return eventData;   
      } else if (eventData.artist == 'Barry'){
        eventData.backgroundColor = 'orange'; 
        eventData.title = eventData.title + ' by Barry';
        return eventData;   
      } else if (eventData.artist == 'Jack'){
        eventData.backgroundColor = 'green'; 
        eventData.title = eventData.title + ' by Jack';
        return eventData;   
      } 
      // else if (eventData.artist == 'Peter Adams'){
      //   eventData.backgroundColor = 'cyan'; 
      //   eventData.title = eventData.title + ' by Peter Adams';
      //   return eventData;   
      // }
    }
  </script>
</body>

</html>