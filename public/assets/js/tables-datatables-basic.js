/**
 * DataTables Basic
 */

'use strict';
let fv, offCanvasEl;
document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const formAddNewRecord = document.getElementById('form-add-new-record');

    setTimeout(() => {
      const newRecord = document.querySelector('.create-new'),
        offCanvasElement = document.querySelector('#add-new-record');

      // To open offCanvas, to add new record
      if (newRecord) {
        newRecord.addEventListener('click', function () {
          offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
          // Empty fields on offCanvas open
          (offCanvasElement.querySelector('.dt-name').value = ''),
            (offCanvasElement.querySelector('.dt-email').value = ''),
            (offCanvasElement.querySelector('.dt-password').value = ''),
          // Open offCanvas with form
          offCanvasEl.show();
        });
      }
    }, 200);

    // Form validation for Add new record
    fv = FormValidation.formValidation(formAddNewRecord, {
      fields: {
        basicFullname: {
          validators: {
            notEmpty: {
              message: 'The name is required'
            }
          }
        },
        email: {
          validators: {
            notEmpty: {
              message: 'Email field is required'
            }
          }
        },
        basicPassword: {
          validators: {
            notEmpty: {
              message: 'The Password is required'
            },
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: '.col-sm-12'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      },
      init: instance => {
        instance.on('plugins.message.placed', function (e) {
          if (e.element.parentElement.classList.contains('input-group')) {
            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
          }
        });
      }
    });

    // FlatPickr Initialization & Validation
    const flatpickrDate = document.querySelector('[name="basicDate"]');

    if (flatpickrDate) {
      flatpickrDate.flatpickr({
        enableTime: false,
        // See https://flatpickr.js.org/formatting/
        dateFormat: 'm/d/Y',
        // After selecting a date, we need to revalidate the field
        onChange: function () {
          fv.revalidateField('basicDate');
        }
      });
    }
  })();
});

// datatable (jquery)
$(function () {
  var selectedRows = {};
  var dt_basic_table = $('.datatables-basic'),dt_basic;

  // DataTable with buttons
  // --------------------------------------------------------------------

    if (dt_basic_table.length) {
      dt_basic = dt_basic_table.DataTable({
        processing: true,
        serverSide: false,
        ajax:{
              "url": usersDataUrl,
              "dataSrc": 'info'
              },
              "beforeSend": function () {
                        $('#loader').fadeIn();  // Show loader before request
                        },
                    "complete": function () {
                        $('#loader').fadeOut(); // Hide loader after data is fetched
                    },
        columns: [
            { data:null , defaultContent : '' },
            { data:null, defaultContent :'' },
            { data:null, defaultContent :'' },
            { data: 'id',visible:false },
            { data: 'name' },
            //{ data: 'email' },
            //{ 
            //  "data": "role",//"visible":false,
            //  "render": function(data, type, row) {
            //    return data ? data.name : 'user'; 
            //  }, 
            //},
            //{ data: 'created_at' },
            //{ data: 'updated_at' },
            { data:null, defaultContent :'' }
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
              // For Checkboxes
              targets: 1,
              orderable: false,
              searchable: false,
              responsivePriority: 3,
              checkboxes: false,
              render: function (data, type, row) {
                return '<input type="checkbox" class="select-checkbox" data-id="' + row.id + '">';
              },
            },
            {
              targets: 2,
              searchable: false,
              visible: false
            },
            {
              responsivePriority: 1,
              targets: 4
            },

          {
              // Actions
              
              targets: -1,
              title: 'Actions',
              orderable: false,
              searchable: false,
              render: function (data, type, full) {
                return (
                '<div class="d-inline-block">' +
                '<a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-md"></i></a>' +
                '<ul class="dropdown-menu dropdown-menu-end m-0">' +
                '<li><a href="javascript:;" class="dropdown-item">Details</a></li>' +
                '<div class="dropdown-divider"></div>' +
                '<li><a href="javascript:;" class="dropdown-item text-danger delete-record"  data-id="' + full.id + '" data-name="' + full.name + '">Delete</a></li>' +
                '</ul>' +
                '</div>' +
                '<a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon btn-edit" data-id="'+full.id+'"><i class="ti ti-pencil ti-md"></i></a>'
                );
              }
            }
          ],
          order: [[2, 'desc']],
          language: {
              processing: "<span class='text-primary'>Loading...</span>"
          },
          initComplete: function (settings, json) {
              $('.card-header').after('<hr class="my-0">');
          },
        order: [[2, 'desc']],
        dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-6 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end mt-n6 mt-md-0"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100],
        language: {
          paginate: {
            next: '<i class="ti ti-chevron-right ti-sm"></i>',
            previous: '<i class="ti ti-chevron-left ti-sm"></i>'
          }
        },
        
        buttons: [
          {
            extend: 'collection',
            className: 'btn btn-label-primary dropdown-toggle me-4 waves-effect waves-light border-none',
            text: '<i class="ti ti-file-export ti-xs me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
            buttons: [
              {
                extend: 'print',
                text: '<i class="ti ti-printer me-1" ></i>Print',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [3, 4, 5, 6, 7],
                  // prevent avatar to be display
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList !== undefined && item.classList.contains('user-name')) {
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
                  //customize print view for dark
                  $(win.document.body)
                    .css('color', config.colors.headingColor)
                    .css('border-color', config.colors.borderColor)
                    .css('background-color', config.colors.bodyBg);
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
                text: '<i class="ti ti-file-text me-1" ></i>Csv',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [3, 4, 5, 6, 7],
                  // prevent avatar to be display
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList !== undefined && item.classList.contains('user-name')) {
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
                text: '<i class="ti ti-file-spreadsheet me-1"></i>Excel',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [3, 4, 5, 6, 7],
                  // prevent avatar to be display
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList !== undefined && item.classList.contains('user-name')) {
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
                text: '<i class="ti ti-file-description me-1"></i>Pdf',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [3, 4, 5, 6, 7],
                  // prevent avatar to be display
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList !== undefined && item.classList.contains('user-name')) {
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
                text: '<i class="ti ti-copy me-1" ></i>Copy',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [3, 4, 5, 6, 7],
                  // prevent avatar to be display
                  format: {
                    body: function (inner, coldex, rowdex) {
                      if (inner.length <= 0) return inner;
                      var el = $.parseHTML(inner);
                      var result = '';
                      $.each(el, function (index, item) {
                        if (item.classList !== undefined && item.classList.contains('user-name')) {
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
          },
           {
             text: '<i class="ti ti-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Record</span>',
             className: 'create-new btn btn-primary waves-effect waves-light'
   
           }

        ],
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
        initComplete: function (settings, json) {
          $('.card-header').after('<hr class="my-0">');
        }
      });

      //DELETE RECORD
      $(document).on('click', '.delete-record', function () {
        
        var id = $(this).data('id');
        var name = $(this).data('name');

        //console.log("Deleting user with ID:", id); // Debugging
    
        if (!id || id === 'undefined' || id === 'null') {
            alert("User ID not found.");
            return;
        }
    
        Swal.fire({
          title: "Are you sure?",
          text: "You are about to delete: " + name,
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        }).then((result=>{
          if(result.isConfirmed){ 
            $.ajax({
                url: deleteUserUrl.replace(':id', id),
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                },
                success: function (response) {
                    toastr.success(name + " has been deleted successfully!",'SUCCESS' );
                    $('.datatables-basic').DataTable().ajax.reload();
                },
                error: function (xhr) {
                  toastr.error("Failed To Delete"+ name , 'ERROR!');
                }
              });
            }
        }))    
    });

    //OPEN EDIT MODAL
      $(document).on('click', '.btn-edit', function() {
        var id = $(this).attr('data-id');

        $.ajax({
        url: editUserUrl.replace(':id', id), 
        type: "GET",
        success: function(response) {
          console.log("User Data:", response);
            $('#editUserId').val(response.id);
            $('#editUserName').val(response.name);
            $('#editUserEmail').val(response.email);
            
        
            // Open Modal - Bootstrap 5 Syntax
            var myModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            myModal.show();
            },
            error: function(xhr) {
            alert("Error fetching user data.");
            }
        });
    });
//SUBMIT EDIT FORM

    $(document).on('submit', '#editUserForm', function(e) {
      e.preventDefault(); 
              
      var id = $('#editUserId').val();
      var name = $('#editUserName').val();
      var email = $('#editUserEmail').val();
      var role = $('#editUserRole').val();
              
      $.ajax({
          url: submitEditForm.replace(':id', id), 
          type: "POST",
          data: {
              _token: csrfToken, 
              id: id,
              name: name,
              email: email,
              role: role
          },
          success: function(response) {
              toastr.success(name + " Edited Successfully","SUCCESS");
              $('#editUserModal').modal('hide'); // Hide modal after update
              $('.datatables-basic').DataTable().ajax.reload(); // Refresh DataTable
          },
          error: function(xhr) {
            toastr.success("Unable To Edit " + name ,"ERROR")
          }
      });
    });

    //CHECK BOXES
    // $('#select-all').on('click', function() {
    //   var rows = $('#myTable').DataTable().rows({ search: 'applied' }).nodes();
    //   $('input[type="checkbox"]', rows).prop('checked', this.checked);
    //   var selectedCount = $('.select-checkbox:checked').length;
    //   $('#deleteRows').toggle(selectedCount > 0);

    // });

    // $('#myTable tbody').on('change', 'input[type="checkbox"]', function() {
    //   var selectedCount = $('.select-checkbox:checked').length;
    //   $('#deleteRows').toggle(selectedCount > 0);
    
    // });
    $('#select-all').on('change', function () {
      var isChecked = this.checked;
  
      // Select all checkboxes, including those not in the current page
      $('.select-checkbox').prop('checked', isChecked);
  
      $('#myTable').DataTable().rows().every(function () {
          var row = this.node();
          var rowId = $(row).find('.select-checkbox').data('id');
  
          if (isChecked) {
              selectedRows[rowId] = true;
          } else {
              delete selectedRows[rowId];
          }
      });
  
      updateDeleteButtonVisibility();
  });
  
  $('#myTable tbody').on('change', '.select-checkbox', function () {
          var rowId = $(this).data('id');
          if (this.checked) {
              selectedRows[rowId] = true;
          } else {
              delete selectedRows[rowId];
              $('#select-all').prop('checked', false);
          }
          if ($('.select-checkbox:checked').length === $('.select-checkbox').length) {
          $('#select-all').prop('checked', true);
      }
  
          updateDeleteButtonVisibility();
      });
      dt_basic.on('draw', function () {
          $('.select-checkbox').each(function () {
              var rowId = $(this).data('id');
              $(this).prop('checked', selectedRows[rowId] === true);
          });
  
          $('#select-all').prop('checked', Object.keys(selectedRows).length === dt_basic.rows().count());
  
          updateDeleteButtonVisibility();
      });
      function updateDeleteButtonVisibility() {
          var selectedCount = Object.keys(selectedRows).length;
          $('#deleteRows').toggle(selectedCount > 0);
      }

    //DELETE SELECTED ROWS WITH CHECKBOXES
    $('#deleteRows').on('click', function () {
      var selectedIds = Object.keys(selectedRows);
      if (selectedIds.length === 0) {
          alert("No users selected.");
          return;
      }

      if (!confirm("Are you sure you want to delete selected users?")) return;

      $.ajax({
          url: selectDeleteUrl,
          type: "POST",
          data: {
              _token: csrfToken,
              ids: selectedIds
          },
          success: function (response) {
              if (response.success) {
                  alert(response.message); 
              } else {
                  alert("Error: " + response.message); 
              }
              selectedRows = {}; 
              dt.ajax.reload();
              updateDeleteButtonVisibility();
          },
          error: function (xhr) {
              console.error(xhr.responseText);
              alert("Error: " + xhr.responseText);
          }
      });
  });
    //submit NewRecord Form
    $(document).on('click','.data-submit',function(e){
      e.preventDefault(); 
      var name = $('.dt-name').val();
      var email = $('.dt-email').val();
      var password = $('.dt-password').val();

      $.ajax({
        url:createRecordUrl, 
        type: "POST",
        data: {
            _token: csrfToken, 
            name: name,
            email: email,
            password: password
        },
        success: function(response) {
            alert(response.success);
            $('#form-add-new-record').modal('hide'); // Hide modal after update
            $('.datatables-basic').DataTable().ajax.reload(); // Refresh DataTable
        },
        error: function(xhr) {
            alert("Error Creating user.");
        }

      });
     // alert("Submit Button From add new record clicked"+name);
    });

  }
 
});
