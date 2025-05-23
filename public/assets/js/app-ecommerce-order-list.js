/**
 * app-ecommerce-order-list Script
 */

'use strict';

// Datatable (jquery)

$(function () {
  let borderColor, bodyBg, headingColor;
  let orders ;
  if (isDarkStyle) {
    borderColor = config.colors_dark.borderColor;
    bodyBg = config.colors_dark.bodyBg;
    headingColor = config.colors_dark.headingColor;
  } else {
    borderColor = config.colors.borderColor;
    bodyBg = config.colors.bodyBg;
    headingColor = config.colors.headingColor;
  }

  // Variable declaration for table

  var dt_order_table = $('.datatables-order'),
    statusObj = {
      'pending': { title: 'pending', class: 'bg-label-warning' },
      'success': { title: 'success', class: 'bg-label-success' },
      'failed': { title: 'failed', class: 'bg-label-primary' },
      'refunded': { title: 'refunded', class: 'bg-label-info' }
    },
    paymentObj = {
      'paid': { title: 'paid', class: 'text-success' },
      'pending': { title: 'pending', class: 'text-warning' },
      'unpaid': { title: 'unpaid', class: 'text-danger' },
      //4: { title: 'Cancelled', class: 'text-secondary' }
    };

  // E-commerce Products datatable

  if (dt_order_table.length) {
    let startDate = null;
    let endDate = null;

    var dt_products = dt_order_table.DataTable({ 
      processing : true ,
      serverSide : false ,
      ajax:{
        'url' : orderListURL,
        'type':'GET',
        data: function (d) {
          d.start_date = startDate;
          d.end_date = endDate;
        },
        'dataSrc' : 'info',
      },
      columns: [
        // columns according to JSON
        { data: null ,defaultContent:'' },
        { data: 'id' },
        { data: 'id', },
        { data: 'created_at' },
        { 
          data: "user",//"visible":false,
          render: function(data, type, row) {
            return data ? data.name : 'user'; 
          }, 
        }, //email //avatar
        { data: 'total' },
        { data: 'status' },
        { data: 'payment_status' }, //method_number
        { data: '' }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            orders = data ;
            return '';
          }
        },
        {
          // For Checkboxes
          targets: 1,
          orderable: false,
          checkboxes: {
            selectAllRender: '<input type="checkbox" class="form-check-input">'
          },
          render: function () {
            return '<input type="checkbox" class="dt-checkboxes form-check-input" >';
          },
          searchable: false
        },
        {
          // Order ID
          targets: 2,
          render: function (data, type, full, meta) {
            var $order_id = full['id'];
            // Creates full output for row
            var $row_output = '<a href="javascript:void(0);" class="orderDetailLink" data-id="' + $order_id + '"><span>#' + $order_id + '</span></a>';
            return $row_output;
          }
        },
        {
          // Date and Time
          targets: 3,
          render: function (data, type, full, meta) {
            var date = new Date(full.created_at); // convert the date string to a Date object
            //console.log("Date "+ date);
            var formattedTime = date.toLocaleTimeString('en-US', {
              hour: '2-digit',
              minute: '2-digit'
            });
            //console.log("time"+formattedTime)
            var formattedDate = date.toLocaleDateString('en-US', {
              month: 'short',
              day: 'numeric',
              year: 'numeric',
            });

            return '<span class="text-nowrap">' + formattedDate + ', ' + formattedTime + '</span>';
          }
        },
        // {
        //   // Customers
        //   targets: 4,
        //   responsivePriority: 1,
        //   render: function (data, type, full, meta) {
        //     var $name = full['customer'],
        //       $email = full['email'],
        //       $avatar = full['avatar'];
        //     if ($avatar) {
        //       // For Avatar image
        //       var $output =
        //         '<img src="' + assetsPath + 'img/avatars/' + $avatar + '" alt="Avatar" class="rounded-circle">';
        //     } else {
        //       // For Avatar badge
        //       var stateNum = Math.floor(Math.random() * 6);
        //       var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
        //       var $state = states[stateNum],
        //         $name = full['customer'],
        //         $initials = $name.match(/\b\w/g) || [];
        //       $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
        //       $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';
        //     }
        //     // Creates full output for row
        //     var $row_output =
        //       '<div class="d-flex justify-content-start align-items-center order-name text-nowrap">' +
        //       '<div class="avatar-wrapper">' +
        //       '<div class="avatar avatar-sm me-3">' +
        //       $output +
        //       '</div>' +
        //       '</div>' +
        //       '<div class="d-flex flex-column">' +
        //       '<h6 class="m-0"><a href="pages-profile-user.html" class="text-heading">' +
        //       $name +
        //       '</a></h6>' +
        //       '<small>' +
        //       $email +
        //       '</small>' +
        //       '</div>' +
        //       '</div>';
        //     return $row_output;
        //   }
        // },
        {
          targets: 7,
          render: function (data, type, full, meta) {
            var $payment = full['payment_status'],
              $paymentObj = paymentObj[$payment];
            if ($paymentObj) {
              return (
                '<h6 class="mb-0 align-items-center d-flex w-px-100 ' +
                $paymentObj.class +
                '">' +
                '<i class="ti ti-circle-filled fs-tiny me-1"></i>' +
                $paymentObj.title +
                '</h6>'
              );
            }
            return data;
          }
        },
        {
          // Status
          targets: -3,
          render: function (data, type, full, meta) {
            var $status = full['status']
            return (
              '<span class="badge px-2 ' +
              statusObj[$status].class +
              '" text-capitalized>' +
              statusObj[$status].title +
              '</span>'
            );
          }
        },
        // {
        //   // Payment Method
        //   targets: -2,
        //   render: function (data, type, full, meta) {
        //     var $method = full['method'];
        //     var $method_number = full['method_number'];

        //     if ($method == 'paypal') {
        //       $method_number = '@gmail.com';
        //     }
        //     return (
        //       '<div class="d-flex align-items-center text-nowrap">' +
        //       '<img src="' +
        //       assetsPath +
        //       'img/icons/payments/' +
        //       $method +
        //       '.png" alt="' +
        //       $method +
        //       '" width="29">' +
        //       '<span><i class="ti ti-dots me-1 mt-1"></i>' +
        //       $method_number +
        //       '</span>' +
        //       '</div>'
        //     );
        //   }
        // },
        {
          // Actions
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex justify-content-sm-start align-items-sm-center">' +
              '<button class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              '<a href="javascript:void(0);" class="dropdown-item viewBtn" data-id="' + full.id + '">View</a>' +
              '<a href="javascript:0;" class="dropdown-item delete-record deleteBtn">' +
              'Delete' +
              '</a>' +
              '</div>' +
              '</div>'
            );
          }
        }
      ],
      order: [3, 'asc'], //set any columns order asc/desc
      dom:
        '<"card-header py-0 d-flex flex-column flex-md-row align-items-center"<f><"d-flex align-items-center justify-content-md-end gap-2 justify-content-center"l<"dt-action-buttons"B>>' +
        '>t' +
        '<"row mx-1"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      lengthMenu: [10, 40, 60, 80, 100], //for length of menu
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search Order',
        info: 'Displaying _START_ to _END_ of _TOTAL_ entries',
        paginate: {
          next: '<i class="ti ti-chevron-right ti-sm"></i>',
          previous: '<i class="ti ti-chevron-left ti-sm"></i>'
        }
      },
      // Buttons with Dropdown
      buttons: [
        {
          extend: 'collection',
          text: 'Filter By Order Date',
          className: 'btn btn-label-secondary dropdown-toggle me-3 ',
          action: function (e, dt, node, config) {
            const $input = $('#orderDateRange');
            const offset = $(node).offset();

            // Position and show the input on top of the button
            $input.css({
              top: offset.top + $(node).outerHeight() + 5 + 'px',
              left: offset.left + 'px',
              display: 'block'
            }).focus(); // open daterangepicker
        }
        },
        {
          extend: 'collection',
          className: 'btn btn-label-secondary dropdown-toggle waves-effect waves-light',
          text: '<i class="ti ti-upload ti-xs me-2"></i>Export',
          buttons: [
            {
              extend: 'print',
              text: '<i class="ti ti-printer me-2"></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [2, 3, 4, 5, 6, 7],
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('order-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              },
              customize: function (win) {
                // Customize print view for dark
                $(win.document.body)
                  .css('color', headingColor)
                  .css('border-color', borderColor)
                  .css('background-color', bodyBg);
                $(win.document.body)
                  .find('table')
                  .addClass('compact')
                  .css('color', 'inherit')
                  .css('border-color', 'inherit')
                  .css('background-color', 'inherit');
              }
            },
            {
              extend: 'csv',
              text: '<i class="ti ti-file me-2"></i>Csv',
              className: 'dropdown-item',
              exportOptions: {
                columns: [2, 3, 4, 5, 6, 7],
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('order-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'excel',
              text: '<i class="ti ti-file-export me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [2, 3, 4, 5, 6, 7],
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('order-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'pdf',
              text: '<i class="ti ti-file-text me-2"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [2, 3, 4, 5, 6, 7],
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('order-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'copy',
              text: '<i class="ti ti-copy me-2"></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [2, 3, 4, 5, 6, 7],
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('order-name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            }
          ]
        }
      ],
      
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['customer'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                ? '<tr data-dt-row="' +
                    col.rowIndex +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/><tbody />').append(data) : false;
          }
        }
      },
      initComplete: function(settings, json) {
        updateCounts(); // Call updateCounts after the DataTable is fully initialized
      },
      drawCallback: function(settings) {
        updateCounts(); // Call updateCounts on every redraw
      }
    });
    $('.dataTables_length').addClass('ms-n2');
    $('.dt-action-buttons').addClass('pt-0');
    $('.dataTables_filter').addClass('ms-n3 mb-0 mb-md-6');
    function updateCounts() {
      // Ensure dt_products is defined and initialized
      if (!dt_products || typeof dt_products.data !== 'function') {
        console.warn('DataTable is not fully initialized yet.');
        return;
      }

      // Get the DataTable data
      const tableData = dt_products.data();

      // Check if tableData is valid
      if (!tableData || tableData.length === 0) {
        console.warn('No data available in DataTable.');
        // Reset counts to 0 if no data
        $('#pendingPayments').text(0);
        $('#completedOrders').text(0);
        $('#refundedOrders').text(0);
        $('#failedOrders').text(0);
        $('#pendingPaymentTab').html(`Pending Payment (0)`);
        $('#completedTab').html(`Completed (0)`);
        $('#refundedTab').html(`Refunded (0)`);
        $('#failedTab').html(`Failed (0)`);
        return;
      }

      let pendingCount = 0, completedCount = 0, refundedCount = 0, failedCount = 0;

      // Loop through the table data to calculate counts
      tableData.toArray().forEach(order => {
        if (order.pending_status === 'pending') pendingCount++;
        if (order.status === 'success') completedCount++;
        if (order.status === 'refunded') refundedCount++;
        if (order.status === 'failed') failedCount++;
      });

      // Update counts in the widget
      $('#pendingPayments').text(pendingCount);
      $('#completedOrders').text(completedCount);
      $('#refundedOrders').text(refundedCount);
      $('#failedOrders').text(failedCount);

      // Update counts in the tabs
      $('#pendingPaymentTab').html(`Pending Payment (${pendingCount})`);
      $('#completedTab').html(`Completed (${completedCount})`);
      $('#refundedTab').html(`Refunded (${refundedCount})`);
      $('#failedTab').html(`Failed (${failedCount})`);
    }
    $('#orderDateRange').daterangepicker({
      opens: 'center',
      autoUpdateInput: false,
      locale: {
        cancelLabel: 'Clear',
        format: 'YYYY-MM-DD'
      },
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')]
      }
    },
    function (start, end) {
      // Format the dates for backend filter
      startDate = start.format('YYYY-MM-DD');
      endDate = end.format('YYYY-MM-DD');
      $('#orderDateRange').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
      dt_products.ajax.reload();
    });
  
    // Clear Date Range
    $('#orderDateRange').on('cancel.daterangepicker', function () {
      $(this).val('');
      startDate = null;
      endDate = null;
      dt_products.ajax.reload();
    });
  
    // Optional: Alert selected dates for debugging
    $('#orderDateRange').on('apply.daterangepicker', function (ev, picker) {
      console.log("Date Range applied", picker.startDate.format(), picker.endDate.format());
      console.log("order"+ orders)
      const start = picker.startDate.format('YYYY-MM-DD');
      const end = picker.endDate.format('YYYY-MM-DD');
      $(this).val(`${start} -TO- ${end}`);
     });
  }

  // Delete Record
  $('.datatables-order tbody').on('click', '.delete-record', function () {
    dt_products.row($(this).parents('tr')).remove().draw();
  });
  $('.datatables-order tbody').on('click','.orderDetailLink',function(){
    var id = $(this).data('id');
    //alert('Btn Clicked'+id);
    if(id){
      window.location.href = orderDetailsURL.replace(':id',id);
    }
  });

  $('.datatables-order tbody').on('click','.viewBtn',function(){
    var id = $(this).data('id');
    if(id){
      //alert('Btn Clicked'+id);
      window.location.href = orderDetailsURL.replace(':id',id);
    }
  });
  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});
