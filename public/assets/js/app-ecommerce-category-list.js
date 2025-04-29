/**
 * App eCommerce Category List
 */

'use strict';

// Comment editor
let modal_title , btn_name ;

const commentEditor = document.querySelector('.comment-editor');
let quill = null;
if (commentEditor) {
  quill = new Quill(commentEditor, {
    modules: {
      toolbar: '.comment-toolbar'
    },
    placeholder: 'Write a Comment...',
    theme: 'snow'
  });
}

// Datatable (jquery)

$(function () {
  var selectedRows = {};
  let borderColor, bodyBg, headingColor;

  if (isDarkStyle) {
    borderColor = config.colors_dark.borderColor;
    bodyBg = config.colors_dark.bodyBg;
    headingColor = config.colors_dark.headingColor;
  } else {
    borderColor = config.colors.borderColor;
    bodyBg = config.colors.bodyBg;
    headingColor = config.colors.headingColor;
  }

  // Variable declaration for category list table
  var dt_category_list_table = $('.datatables-category-list');

  //select2 for dropdowns in offcanvas

  var select2 = $('.select2');
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent(),
        placeholder: $this.data('placeholder') //for dynamic placeholder
      });
    });
  }

  // Customers List Datatable

  if (dt_category_list_table.length) {
    var dt_category = dt_category_list_table.DataTable({
     processing: true,
        serverSide: false,
        ajax:{
              "url": categoriesDataURL,
              "dataSrc": 'info'
              }, // JSON file to add data
      columns: [
        // columns according to JSON
        { data :null ,defaultContent:''},
        { data: 'id' ,visible:false },
        { data: 'title' },
        { data: 'slug' },
        { data: 'image' },
        { data: 'parent_id' },
        { data : 'description'},
        { data : 'status'},
        { data: '' }
      ],
      columnDefs: [
        // {
        //   // For Responsive
        //   className: 'control',
        //   searchable: false,
        //   orderable: false,
        //   responsivePriority: 1,
        //   targets: 0,
        //   render: function (data, type, full, meta) {
        //     return '';
        //   }
        // },
        {
          // For Checkboxes
          targets: 0,
          orderable: false,
          searchable: false,
          responsivePriority: 3,
          checkboxes: false,
          render: function (data, type, row) {
            return '<input type="checkbox" class="select-checkbox" data-id="' + row.id + '">';
          },
        },
        {
          targets: 4, // Adjust target index to match the column
          render: function (data, type, full, meta) {
            const text = full['image']; // or whatever your field is
            const shortText = text.length > 6 ? text.substring(0, 6) + '...' : text;
            return shortText;
          }
        },
        // {
        //   // Categories and Category Detail
        //   targets: 2,
        //   responsivePriority: 2,
        //   render: function (data, type, full, meta) {
        //     var $name = full['categories'],
        //       $category_detail = full['category_detail'],
        //       $image = full['cat_image'],
        //       $id = full['id'];
        //     if ($image) {
        //       // For Product image
        //       var $output =
        //         '<img src="' +
        //         assetsPath +
        //         'img/ecommerce-images/' +
        //         $image +
        //         '" alt="Product-' +
        //         $id +
        //         '" class="rounded-2">';
        //     } else {
        //       // For Product badge
        //       var stateNum = Math.floor(Math.random() * 6);
        //       var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
        //       var $state = states[stateNum],
        //         $name = full['category_detail'],
        //         $initials = $name.match(/\b\w/g) || [];
        //       $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
        //       $output = '<span class="avatar-initial rounded-2 bg-label-' + $state + '">' + $initials + '</span>';
        //     }
        //     // Creates full output for Categories and Category Detail
        //     var $row_output =
        //       '<div class="d-flex align-items-center">' +
        //       '<div class="avatar-wrapper me-3 rounded-2 bg-label-secondary">' +
        //       '<div class="avatar">' +
        //       $output +
        //       '</div>' +
        //       '</div>' +
        //       '<div class="d-flex flex-column justify-content-center">' +
        //       '<span class="text-heading text-wrap fw-medium">' +
        //       $name +
        //       '</span>' +
        //       '<span class="text-truncate mb-0 d-none d-sm-block"><small>' +
        //       $category_detail +
        //       '</small></span>' +
        //       '</div>' +
        //       '</div>';
        //     return $row_output;
        //   }
        // },
        // {
        //   // Total products
        //   targets: 3,
        //   responsivePriority: 3,
        //   render: function (data, type, full, meta) {
        //     var $total_products = full['total_products'];
        //     return '<div class="text-sm-end">' + $total_products + '</div>';
        //   }
        // },
        // {
        //   // Total Earnings
        //   targets: 4,
        //   orderable: false,
        //   render: function (data, type, full, meta) {
        //     var $total_earnings = full['total_earnings'];
        //     return "<div class='mb-0 text-sm-end'>" + $total_earnings + '</div';
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
              '<div class="d-inline-block">' +
                '<a href="javascript:;" class=" text-danger delete-record" data-id="'+full.id+'"><i class="ti ti-trash me-1"></i></a>' +
                '<a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon edit-btn" data-id="'+full.id+'"><i class="ti ti-pencil ti-md"></i></a>'
            );
          }
        }
      ],
      order: [2, 'desc'], //set any columns order asc/desc
      dom:
        '<"card-header d-flex flex-wrap py-0 flex-column flex-sm-row"' +
        '<f>' +
        '<"d-flex justify-content-center justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex justify-content-center flex-md-row align-items-baseline"lB>>' +
        '>t' +
        '<"row mx-1"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      lengthMenu: [7, 10, 20, 50, 70, 100], //for length of menu
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search Category',
        paginate: {
          next: '<i class="ti ti-chevron-right ti-sm"></i>',
          previous: '<i class="ti ti-chevron-left ti-sm"></i>'
        }
      },
      // Button for offcanvas
      buttons: [
        {
          text: '<i class="ti ti-plus ti-xs me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add Category</span>',
          className: 'add-new btn btn-primary ms-2 waves-effect waves-light',
          attr: {
            'data-bs-toggle': 'offcanvas',
            'data-bs-target': '#offcanvasEcommerceCategoryList'
          }
        }
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data.title;
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
                    '<td> ' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td class="ps-0">' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/><tbody />').append(data) : false;
          }
        }
      },
      drawCallback: function () {
        //Attach checkbox click after each draw
        $('.select-checkbox').on('click', function () {
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
        console.log('Selected Rows:', selectedRows);
          $('#deleteRows').show();
        });
        
//select-all
    $('#select-all').on('change', function () {
      var isChecked = this.checked;
      $('.select-checkbox').prop('checked', isChecked);
      if (isChecked) {
        $('.select-checkbox').each(function () {
          const rowId = $(this).data('id');
          if (rowId !== undefined) {
            selectedRows[rowId] = true;
          }
        });
      } else {
        selectedRows = {};
      }
      console.log('Selected Rows:', selectedRows);
      if (Object.keys(selectedRows).length > 0) {
        $('#deleteRows').show();
      } else {
        $('#deleteRows').hide();
      }
    });
  }
});

    $('.dt-action-buttons').addClass('pt-0');
    $('.dataTables_filter').addClass('me-3 mb-sm-6 mb-0 ps-0');
  }

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_filter .form-control').addClass('ms-0');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
    $('.dataTables_length .form-select').addClass('ms-0');
  }, 300);
  $('#deleteRows').on('click', function () {
    var selectedIds = Object.keys(selectedRows);
    console.log(selectedIds);
    if (selectedIds.length === 0) {
        alert("No users selected.");
        return;
    }
    if (confirm("Are you sure you want to delete selected users?")){
    $.ajax({
        url: selectDeleteUrl,
        type: "POST",
        data: {
            ids: selectedIds
        },
        headers: {
          "X-CSRF-TOKEN": csrfToken
        },
        success: function (response) {
            selectedRows = {}; 
            $('.datatables-category-list').DataTable().ajax.reload();
            alert(response.success);
            $('#deleteRows').hide();
        },
        error: function (xhr) {
          var err = JSON.parse(xhr.responseText);
          alert(err.error);
        }
    });
  }
  });
  
});

//Open Modal For Edit Btn Clicked
$(document).on('click', '.edit-btn', function () {
  var id = $(this).data('id');
  $.ajax({
    url:editCategoryURL.replace(':id', id),
    type:"GET",
    success:function(response){
      console.log("Selected Category Data:", response);
      
      $('#ecommerce-category-id').val(response.id);
      $('#ecommerce-category-title').val(response.title);
      $('#ecommerce-category-slug').val(response.slug);
      $('#ecommerce-category-description').val(response.description);
     // $('#ecommerce-category-image').val(response.image);
      $('#ecommerce-category-status').val(response.status).trigger('change');
      var parent_id = response.parent_id , parent_category;
      
      if(parent_id==1){
        parent_category = "Household";
      }else if(parent_id==2){
        parent_category = "Management";
      }else if(parent_id==3){
        parent_category = "Electronics"
      }else if(parent_id==4){
        parent_category = "Office"
      }

      $('#ecommerce-category-parent-category').val(parent_category).trigger('change');
      const offcanvas = new bootstrap.Offcanvas('#offcanvasEcommerceCategoryList');
      offcanvas.show();
      modal_title = $('#offcanvasEcommerceCategoryListLabel').text('Update Category');
      const a = $('#addBtn');
      a.removeClass('data-submit');
      a.addClass('data-update');
      btn_name = a.text('Update');
      console.log("Edit-Btn clicked-Text",btn_name.text());
    },
    error:function(){
      alert("Error fetching user data.");
    },
  });
});
//Reset The Form
$(document).on('click', '.add-new', function () {
  $('#eCommerceCategoryListForm')[0].reset();
  $('#ecommerce-category-id').val('');
  quill.root.innerHTML = '';
  $('#ecommerce-category-parent-category').val(null).trigger('change');
  $('#ecommerce-category-status').val(null).trigger('change');

  const a = $('#addBtn');
  a.removeClass('data-update');
  a.addClass('data-submit');
  btn_name = a.text('Add');
  modal_title = $('#offcanvasEcommerceCategoryListLabel');
  modal_title.text('Add Category');

  console.log("Reset Form Btn Text : ", btn_name.text());
});
//delete record
$(document).on('click','.delete-record',function(){
  var id = $(this).data('id');
  if (confirm('Are you sure you want to delete this item?')) {
  $.ajax({
    url : deleteCategoryURL.replace(':id', id),
    type : "DELETE",
    headers: {
      "X-CSRF-TOKEN": csrfToken
    },
    success : function(response){
      toastr.success(response.success);
      $('.datatables-category-list').DataTable().ajax.reload();
    },
    error : function(xhr){
      var err = JSON.parse(xhr.responseText);
      toastr.error(err.error);
    }
  });
}
});
// Category-Update Form Submission
$('#eCommerceCategoryListForm').on('click','.data-update',function(e){
  
  console.log('update conso',btn_name.text());
  e.preventDefault();
  //alert("Button Clicked");
  const updateBtn = $('.data-update');
  updateBtn.prop('disabled', true).text('Updating...');

    var id = $('#ecommerce-category-id').val();
    var title = $('#ecommerce-category-title').val();
    var slug = $('#ecommerce-category-slug').val();
    const descriptionHtml = quill.root.innerHTML.trim();
    var description = $('#description').val(descriptionHtml);
    var image = $('#ecommerce-category-image').val();
    var status = $('#ecommerce-category-status').val();
    var parent_category = $('#ecommerce-category-parent-category').val();
    var parent_id;
    //alert("ID "+id+"title" + title + "Status "+ slug +"Description "+ description +"Status"+ status +"Parent "+ parent_category + "image "+image);
    if(parent_category=="Household"){
      parent_id =1 ;
    }else if(parent_category=="Management"){
      parent_id = 2;
    }else if(parent_category=="Electronics"){
      parent_id = 3;
    }else if(parent_category=="Office"){
      parent_id = 4;
    }
    $.ajax({
      url : submitEditCategoryFormURL,
      type : "POST",
      data : { 
        id: id,
        title: title,
        slug: slug,
        description: description,
        parent_category:parent_id,
        image:image,
        status:status
    },
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Proper header
    },
      success : function(response){
        $('.datatables-category-list').DataTable().ajax.reload();
          toastr.success('Category Updated successfully!');
          $('#offcanvasEcommerceCategoryList').offcanvas('hide');
          quill.root.innerHTML = '';
      },
      error : function(xhr){
        toastr.error('Something went wrong. Please try again.');
      },
      complete  : function () {
        btn_name = updateBtn.prop('disabled', false).text('Add');
        //console.log(btn_name.text());
      }
    });
});
//For form validation
(function () {
  const eCommerceCategoryListForm = document.getElementById('eCommerceCategoryListForm');
  //Add New customer Form Validation
  const fv = FormValidation.formValidation(eCommerceCategoryListForm, {
    fields: {
      categoryTitle: {
        validators: {
          notEmpty: {
            message: 'Please enter category title'
          }
        }
      },
      slug: {
        validators: {
          notEmpty: {
            message: 'Please enter slug'
          }
        }
      },
      description:{
        validators:{
          notEmpty:{
            message:'Please enter description'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        // Use this for enabling/changing valid/invalid class
        eleValidClass: 'is-valid',
        rowSelector: function (field, ele) {
          // field is the field name & ele is the field element
          return '.mb-6';
        }
      }),
    //  submitButton: new FormValidation.plugins.SubmitButton(),
      // Submit the form when all fields are valid
      // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
      //autoFocus: new FormValidation.plugins.AutoFocus()
    }
  });
  fv.on('core.form.validating', function () {
    const quillContent = quill.root.innerHTML.trim();
    $('#description').val(quillContent);
  });

  //Category-Add Form Submission

$('#eCommerceCategoryListForm').on('submit', function (e) {
  e.preventDefault();
  console.log('Add-Btn : ',btn_name);
  if(btn_name.text()==='Add')
  {
    console.log('enter',btn_name.text());
  }
  // Set description value from Quill editor
  const descriptionHtml = quill.root.innerHTML.trim();
  $('#description').val(descriptionHtml);

  // Validate form fields
  fv.validate().then(function (status) {
    if (status === 'Valid') {
      const form = document.getElementById('eCommerceCategoryListForm');
      const formData = new FormData(form);

      // Append manually selected values (Select2 dropdowns)
      formData.append('parent_category', $('#ecommerce-category-parent-category').val());
      formData.append('status', $('#ecommerce-category-status').val());
      console.log('Full FormData content:');
      for (let [key, value] of formData.entries()) {
        console.log(key, value);
      } 
      // Optional: Disable the submit button to prevent multiple clicks
      const submitBtn = $('.data-submit');
      submitBtn.prop('disabled', true).text('Submitting...');

      $.ajax({
        url: categoriesFormSubmit, 
        type: "POST",
        data: formData,
        contentType: false, 
        processData: false, 
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Proper header
        },
        success: function (response) {
          // Reload DataTable and reset form
          $('.datatables-category-list').DataTable().ajax.reload();
          toastr.success('Category added successfully!');
          $('#offcanvasEcommerceCategoryList').offcanvas('hide');
          form.reset();
          quill.root.innerHTML = '';
        },
        error: function (xhr) {
          toastr.error('Something went wrong. Please try again.');
        },
        complete: function () {
          // Re-enable submit button
          submitBtn.prop('disabled', false).text('Add');
        }
      });
    }
  });
});

})();




