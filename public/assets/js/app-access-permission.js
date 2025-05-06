/**
 * App user list (jquery)
 */

'use strict';

$(function () {
  var dataTablePermissions = $('.datatables-permissions'),
    dt_permission,
    userList = 'app-user-list.html';

  // Users List datatable
  if (dataTablePermissions.length) {
    dt_permission = dataTablePermissions.DataTable({
      processing : true,
      serverSide :false,
      ajax : {
        'url' : permissionsListURL ,
        'dataSrc' : 'info' 
      } ,// JSON file to add data
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'id' },
        { data: 'name' },
        // { data: 'assigned_to' },
        { data: 'created_at' },
        { data: '' }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          orderable: false,
          searchable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return '';
          }
        },
        {
          targets: 1,
          searchable: false,
          visible: false
        },
        {
          // Name
          targets: 2,
          render: function (data, type, full, meta) {
            var $name = full['name'];
            return '<span class="text-nowrap text-heading">' + $name + '</span>';
          }
        },
        // {
        //   // User Role
        //   targets: 3,
        //   orderable: false,
        //   render: function (data, type, full, meta) {
        //     var $assignedTo = full['assigned_to'],
        //       $output = '';
        //     var roleBadgeObj = {
        //       Admin: '<a href="' + userList + '"><span class="badge me-4 bg-label-primary">Administrator</span></a>',
        //       Manager: '<a href="' + userList + '"><span class="badge me-4 bg-label-warning">Manager</span></a>',
        //       Users: '<a href="' + userList + '"><span class="badge me-4 bg-label-success">Users</span></a>',
        //       Support: '<a href="' + userList + '"><span class="badge me-4 bg-label-info">Support</span></a>',
        //       Restricted:
        //         '<a href="' + userList + '"><span class="badge me-4 bg-label-danger">Restricted User</span></a>'
        //     };
        //     for (var i = 0; i < $assignedTo.length; i++) {
        //       var val = $assignedTo[i];
        //       $output += roleBadgeObj[val];
        //     }
        //     return '<span class="text-nowrap">' + $output + '</span>';
        //   }
        // },
        {
          // remove ordering from Name
          targets: 3,
          orderable: false,
          render: function (data, type, full, meta) {
            var $date = full['created_at'];
            if (!$date) {
              return '<span class="text-nowrap">-</span>';
          }
          var date = new Date($date);
          if (isNaN(date.getTime())) {
              return '<span class="text-nowrap">-</span>';
          }
          var formattedDate = date.toLocaleDateString('en-US', {
              month: 'long',
              day: 'numeric',
              year: 'numeric'
          });
          var formattedTime = date.toLocaleTimeString('en-US', {
              hour: '2-digit',
              minute: '2-digit',
              hour12: true
          });
          return '<span class="text-nowrap">' + formattedDate + ' ' + formattedTime + '</span>';
          }
        },
        {
          // Actions
          targets: -1,
          searchable: false,
          title: 'Actions',
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center">' +
              '<span class="text-nowrap"><button class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill me-1 editBtn"  data-permission=\'' + JSON.stringify(full) + '\' data-bs-target="#editPermissionModal" data-bs-toggle="modal" data-id="'+full.id+'" title="Edit Permission"><i class="ti ti-edit ti-md"></i></button>' +
              '<a href="javascript:;" class=" text-danger delete-record" data-id="'+full.id+'" title="Delete Permission"><i class="ti ti-trash me-1"></i></a>' +
              '</div>'
            );
          }
        }
      ],
      order: [[1, 'asc']],
      dom:
        '<"row mx-1"' +
        '<"col-sm-12 col-md-3" l>' +
        '<"col-sm-12 col-md-9"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap"<"me-4 mt-n6 mt-md-0"f>B>>' +
        '>t' +
        '<"row"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: 'Show _MENU_',
        search: '',
        searchPlaceholder: 'Search Permissions',
        paginate: {
          next: '<i class="ti ti-chevron-right ti-sm"></i>',
          previous: '<i class="ti ti-chevron-left ti-sm"></i>'
        }
      },
      // Buttons with Dropdown
      buttons: [
        {
          text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add Permission</span>',
          className: 'add-new btn btn-primary mb-6 mb-md-0 waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'modal',
            'data-bs-target': '#addPermissionModal'
          },
          init: function (api, node, config) {
            $(node).removeClass('btn-secondary');
          }
        }
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['name'];
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
      initComplete: function () {
        // Adding role filter once table initialized
        this.api()
          .columns(3)
          .every(function () {
            var column = this;
            var select = $(
              '<select id="UserRole" class="form-select text-capitalize"><option value=""> Select Role </option></select>'
            )
              .appendTo('.user_role')
              .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d, j) {
                select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
              });
          });
      }
    });
  }

  // Delete Record
  $('.datatables-permissions tbody').on('click', '.delete-record', function () {
    var id = $(this).data('id');
    //alert("ID : " +id);
    if (!confirm('Are you sure you want to update this permission?')) {
      return; // Cancel the action if user clicks "Cancel"
    }
    $.ajax({
      url : permissionDeleteURL.replace(':id',id),
      type : 'Delete' , 
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Proper header
      },
      success : function(response){
        if (typeof dt_permission !== 'undefined') {
          dt_permission.ajax.reload(); 
        } else {
          console.warn('DataTable (dt_permission) is not defined or initialized.');
          location.reload();
        }
      },
      error : function(xhr){
        let errorMessage = 'An error occurred while creating the permission.';
        if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;
            errorMessage = Object.values(errors).flat().join('\n');
        } else if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
        }
        alert(errorMessage);
      }
    })
  });

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
    $('.dataTables_info').addClass('ms-n1');
    $('.dataTables_paginate').addClass('me-n1');
  }, 300);
});
