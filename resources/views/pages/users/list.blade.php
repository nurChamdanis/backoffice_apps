<!-- 
expose component model to current view
e.g $arrDataFromDb = $comp_model->fetchData(); //function name
-->
@inject('comp_model', 'App\Models\ComponentsData')
<?php
    //check if current user role is allowed access to the pages
    $can_add = $user->canAccess("users/add");
    $can_edit = $user->canAccess("users/edit");
    $can_view = $user->canAccess("users/view");
    $can_delete = $user->canAccess("users/delete");
    $field_name = request()->segment(3);
    $field_value = request()->segment(4);
    $total_records = $records->total();
    $limit = $records->perPage();
    $record_count = count($records);
    $pageTitle = "Users"; //set dynamic page title
?>
@extends($layout)
@section('title', $pageTitle)
@section('content')
<section class="page" data-page-type="list" data-page-url="{{ url()->full() }}">
    <?php
        if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3" >
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center gap-3">
                <div class="col  " >
                    <div class="">
                        <div class="h5 font-weight-bold text-primary">Users</div>
                    </div>
                </div>
                <div class="col-auto  " >
                    <a  class="btn " href="<?php print_link("users/add") ?>" >
                    <i class="icon dripicons-plus"></i>                             
                    Add New User 
                </a>
            </div>
            <div class="col-md-3  " >
                <!-- Page drop down search component -->
                <form  class="search" action="{{ url()->current() }}" method="get">
                    <input type="hidden" name="page" value="1" />
                    <div class="input-group">
                        <input value="<?php echo get_value('search'); ?>" class="form-control page-search" type="text" name="search"  placeholder="Search" />
                        <button class="btn btn-primary"><i class="icon dripicons-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    }
?>
<div  class="" >
    <div class="container-fluid">
        <div class="row ">
            <div class="col comp-grid " >
                <div  class=" page-content" >
                    <div id="users-list-records">
                        <div id="page-main-content" class="table-responsive">
                            <?php Html::page_bread_crumb("/users/", $field_name, $field_value); ?>
                            <?php Html::display_page_errors($errors); ?>
                            <div class="filter-tags mb-2">
                                <?php Html::filter_tag('search', __('Search')); ?>
                            </div>
                            <table class="table table-hover table-striped table-sm text-left">
                                <thead class="table-header ">
                                    <tr>
                                        <?php if($can_delete){ ?>
                                        <th class="td-checkbox">
                                        <label class="form-check-label">
                                        <input class="toggle-check-all form-check-input" type="checkbox" />
                                        </label>
                                        </th>
                                        <?php } ?>
                                        <th class="td-picture" > Picture</th>
                                        <th class="td-email" > Email</th>
                                        <th class="td-created_at" > Created At</th>
                                        <th class="td-updated_at" > Updated At</th>
                                        <th class="td-phone" > Phone</th>
                                        <th class="td-username" > Username</th>
                                        <th class="td-saldo_balance" > Saldo Balance</th>
                                        <th class="td-account_status" > Account Status</th>
                                        <th class="td-role_name" > Role Name</th>
                                        <th class="td-role_id" > Role Id</th>
                                        <th class="td-btn"></th>
                                    </tr>
                                </thead>
                                <?php
                                    if($total_records){
                                ?>
                                <tbody class="page-data">
                                    <!--record-->
                                    <?php
                                        $counter = 0;
                                        foreach($records as $data){
                                        $rec_id = ($data['id'] ? urlencode($data['id']) : null);
                                        $counter++;
                                        //check if user is the owner of the record.
                                        $is_record_owner = ($data['id'] == $user->id);
                                        $can_edit_record = $can_delete_record = $is_record_owner;
                                    ?>
                                    <tr>
                                        <?php if($can_delete){ ?>
                                        <td class=" td-checkbox">
                                            <?php if($can_delete_record) { ?>
                                            <label class="form-check-label">
                                            <input class="optioncheck form-check-input" name="optioncheck[]" value="<?php echo $data['id'] ?>" type="checkbox" />
                                            </label>
                                            <?php } ?>
                                        </td>
                                        <?php } ?>
                                        <!--PageComponentStart-->
                                        <td class="td-picture">
                                            <?php 
                                                Html :: page_img($data['picture'], '50px', '50px', "small", 1); 
                                            ?>
                                        </td>
                                        <td class="td-email">
                                            <a href="<?php print_link("mailto:$data[email]") ?>"><?php echo $data['email']; ?></a>
                                        </td>
                                        <td class="td-created_at">
                                            <?php echo  $data['created_at'] ; ?>
                                        </td>
                                        <td class="td-updated_at">
                                            <?php echo  $data['updated_at'] ; ?>
                                        </td>
                                        <td class="td-phone">
                                            <a href="<?php print_link("tel:$data[phone]") ?>"><?php echo $data['phone']; ?></a>
                                        </td>
                                        <td class="td-username">
                                            <span <?php if($can_edit){ ?> data-source='<?php print_link('componentsdata/username_option_list'); ?>' 
                                            data-value="<?php echo $data['username']; ?>" 
                                            data-pk="<?php echo $data['id'] ?>" 
                                            data-url="<?php print_link("users/edit/" . urlencode($data['id'])); ?>" 
                                            data-name="username" 
                                            data-title="Enter Username" 
                                            data-placement="left" 
                                            data-toggle="click" 
                                            data-type="text" 
                                            data-mode="popover" 
                                            data-showbuttons="left" 
                                            class="is-editable" <?php } ?>>
                                            <?php echo  $data['username'] ; ?>
                                            </span>
                                        </td>
                                        <td class="td-saldo_balance">
                                            <span <?php if($can_edit){ ?> data-step="0.1" 
                                            data-source='<?php print_link('componentsdata/username_option_list'); ?>' 
                                            data-value="<?php echo $data['saldo_balance']; ?>" 
                                            data-pk="<?php echo $data['id'] ?>" 
                                            data-url="<?php print_link("users/edit/" . urlencode($data['id'])); ?>" 
                                            data-name="saldo_balance" 
                                            data-title="Enter Saldo Balance" 
                                            data-placement="left" 
                                            data-toggle="click" 
                                            data-type="number" 
                                            data-mode="popover" 
                                            data-showbuttons="left" 
                                            class="is-editable" <?php } ?>>
                                            <?php echo  $data['saldo_balance'] ; ?>
                                            </span>
                                        </td>
                                        <td class="td-account_status">
                                            <?php echo  $data['account_status'] ; ?>
                                        </td>
                                        <td class="td-role_name">
                                            <span <?php if($can_edit){ ?> data-source='<?php print_link('componentsdata/role_name_option_list'); ?>' 
                                            data-value="<?php echo $data['role_name']; ?>" 
                                            data-pk="<?php echo $data['id'] ?>" 
                                            data-url="<?php print_link("users/edit/" . urlencode($data['id'])); ?>" 
                                            data-name="role_name" 
                                            data-title="Select a value ..." 
                                            data-placement="left" 
                                            data-toggle="click" 
                                            data-type="select" 
                                            data-mode="popover" 
                                            data-showbuttons="left" 
                                            class="is-editable" <?php } ?>>
                                            <?php echo  $data['role_name'] ; ?>
                                            </span>
                                        </td>
                                        <td class="td-role_id">
                                            <span <?php if($can_edit){ ?> data-source='<?php print_link('componentsdata/role_name_option_list'); ?>' 
                                            data-value="<?php echo $data['role_id']; ?>" 
                                            data-pk="<?php echo $data['id'] ?>" 
                                            data-url="<?php print_link("users/edit/" . urlencode($data['id'])); ?>" 
                                            data-name="role_id" 
                                            data-title="Select a value ..." 
                                            data-placement="left" 
                                            data-toggle="click" 
                                            data-type="select" 
                                            data-mode="popover" 
                                            data-showbuttons="left" 
                                            class="is-editable" <?php } ?>>
                                            <?php echo  $data['role_id'] ; ?>
                                            </span>
                                        </td>
                                        <!--PageComponentEnd-->
                                        <td class="td-btn">
                                            <div class="dropdown" >
                                                <button data-bs-toggle="dropdown" class="dropdown-toggle btn text-primary btn-flat btn-sm">
                                                <i class="icon dripicons-menu"></i> 
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <?php if($can_view){ ?>
                                                    <a class="dropdown-item "   href="<?php print_link("users/view/$rec_id"); ?>" >
                                                    <i class="icon dripicons-preview"></i> View
                                                </a>
                                                <?php } ?>
                                                <?php if($can_edit_record){ ?>
                                                <a class="dropdown-item "   href="<?php print_link("users/edit/$rec_id"); ?>" >
                                                <i class="icon dripicons-document-edit"></i> Edit
                                            </a>
                                            <?php } ?>
                                            <?php if($can_delete_record){ ?>
                                            <a class="dropdown-item record-delete-btn" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal" href="<?php print_link("users/delete/$rec_id"); ?>" >
                                            <i class="icon dripicons-cross"></i> Delete
                                        </a>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            }
                        ?>
                        <!--endrecord-->
                    </tbody>
                    <tbody class="search-data"></tbody>
                    <?php
                        }
                        else{
                    ?>
                    <tbody class="page-data">
                        <tr>
                            <td class="bg-light text-center text-muted animated bounce p-3" colspan="1000">
                                <i class="icon dripicons-wrong"></i> No record found
                            </td>
                        </tr>
                    </tbody>
                    <?php
                        }
                    ?>
                </table>
            </div>
            <?php
                if($show_footer){
            ?>
            <div class=" mt-3">
                <div class="row align-items-center justify-content-between">    
                    <div class="col-md-auto d-flex">    
                        <?php if($can_delete){ ?>
                        <button data-prompt-msg="Are you sure you want to delete these records?" data-display-style="modal" data-url="<?php print_link("users/delete/{sel_ids}"); ?>" class="btn btn-sm btn-danger btn-delete-selected d-none">
                        <i class="icon dripicons-cross"></i> Delete Selected
                        </button>
                        <?php } ?>
                        <div class="dropup export-btn-holder">
                            <button  class="btn  btn-sm btn-outline-primary dropdown-toggle" title="Export" type="button" data-bs-toggle="dropdown">
                            <i class="icon dripicons-document-new"></i> 
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?php Html :: export_menus(['pdf', 'print', 'excel', 'csv']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">   
                        <?php
                            if($show_pagination == true){
                            $pager = new Pagination($total_records, $record_count);
                            $pager->show_page_count = false;
                            $pager->show_record_count = true;
                            $pager->show_page_limit =false;
                            $pager->limit = $limit;
                            $pager->show_page_number_list = true;
                            $pager->pager_link_range=5;
                            $pager->render();
                            }
                        ?>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</div>
</div>
</div>
</div>
</section>
@endsection
<!-- Page custom css -->
@section('pagecss')
<style>

</style>
@endsection
<!-- Page custom js -->
@section('pagejs')
<script>
    <!--pageautofill-->
$(document).ready(function(){
	// custom javascript | jquery codes
});

</script>
@endsection
