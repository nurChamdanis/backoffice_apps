<!-- 
expose component model to current view
e.g $arrDataFromDb = $comp_model->fetchData(); //function name
-->
@inject('comp_model', 'App\Models\ComponentsData')
<?php
    $pageTitle = "Edit User"; //set dynamic page title
?>
@extends($layout)
@section('title', $pageTitle)
@section('content')
<section class="page" data-page-type="edit" data-page-url="{{ url()->full() }}">
    <?php
        if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3" >
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto  back-btn-col" >
                    <a class="back-btn btn " href="{{ url()->previous() }}" >
                        <i class="icon dripicons-arrow-thin-left"></i>                              
                    </a>
                </div>
                <div class="col  " >
                    <div class="">
                        <div class="h5 font-weight-bold text-primary">Edit User</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        }
    ?>
    <div  class="" >
        <div class="container">
            <div class="row ">
                <div class="col-md-9 comp-grid " >
                    <div  class="card card-1 border rounded page-content" >
                        <!--[form-start]-->
                        <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("users/edit/$rec_id"); ?>" method="post">
                        <!--[form-content-start]-->
                        @csrf
                        <div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="first_name">First Name </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-first_name-holder" class=" ">
                                            <input id="ctrl-first_name" data-field="first_name"  value="<?php  echo $data['first_name']; ?>" type="text" placeholder="Enter First Name"  name="first_name"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="last_name">Last Name </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-last_name-holder" class=" ">
                                            <input id="ctrl-last_name" data-field="last_name"  value="<?php  echo $data['last_name']; ?>" type="text" placeholder="Enter Last Name"  name="last_name"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="signup_ip_address">Signup Ip Address </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-signup_ip_address-holder" class=" ">
                                            <input id="ctrl-signup_ip_address" data-field="signup_ip_address"  value="<?php  echo $data['signup_ip_address']; ?>" type="text" placeholder="Enter Signup Ip Address"  name="signup_ip_address"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="signup_confirmation_ip_address">Signup Confirmation Ip Address </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-signup_confirmation_ip_address-holder" class=" ">
                                            <input id="ctrl-signup_confirmation_ip_address" data-field="signup_confirmation_ip_address"  value="<?php  echo $data['signup_confirmation_ip_address']; ?>" type="text" placeholder="Enter Signup Confirmation Ip Address"  name="signup_confirmation_ip_address"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="signup_sm_ip_address">Signup Sm Ip Address </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-signup_sm_ip_address-holder" class=" ">
                                            <input id="ctrl-signup_sm_ip_address" data-field="signup_sm_ip_address"  value="<?php  echo $data['signup_sm_ip_address']; ?>" type="text" placeholder="Enter Signup Sm Ip Address"  name="signup_sm_ip_address"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="admin_ip_address">Admin Ip Address </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-admin_ip_address-holder" class=" ">
                                            <input id="ctrl-admin_ip_address" data-field="admin_ip_address"  value="<?php  echo $data['admin_ip_address']; ?>" type="text" placeholder="Enter Admin Ip Address"  name="admin_ip_address"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="updated_ip_address">Updated Ip Address </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-updated_ip_address-holder" class="input-group ">
                                            <input id="ctrl-updated_ip_address" data-field="updated_ip_address" class="form-control datepicker  datepicker" value="<?php  echo $data['updated_ip_address']; ?>" type="datetime"  name="updated_ip_address" placeholder="Enter Updated Ip Address" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
                                            <span class="input-group-text"><i class="icon dripicons-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="deleted_ip_address">Deleted Ip Address </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-deleted_ip_address-holder" class=" ">
                                            <input id="ctrl-deleted_ip_address" data-field="deleted_ip_address"  value="<?php  echo $data['deleted_ip_address']; ?>" type="text" placeholder="Enter Deleted Ip Address"  name="deleted_ip_address"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="phone">Phone </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-phone-holder" class=" ">
                                            <input id="ctrl-phone" data-field="phone"  value="<?php  echo $data['phone']; ?>" type="number" placeholder="Enter Phone" step="any"  name="phone"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="picture">Foto </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-picture-holder" class=" ">
                                            <div class="dropzone " input="#ctrl-picture" fieldname="picture" uploadurl="{{ url('fileuploader/upload/picture') }}"    data-multiple="false" dropmsg="Choose files or drop files here"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="3" maximum="1">
                                                <input name="picture" id="ctrl-picture" data-field="picture" class="dropzone-input form-control" value="<?php  echo $data['picture']; ?>" type="text"  />
                                                <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                            </div>
                                        </div>
                                        <?php Html :: uploaded_files_list($data['picture'], '#ctrl-picture'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="username">Username <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-username-holder" class=" ">
                                            <input id="ctrl-username" data-field="username"  value="<?php  echo $data['username']; ?>" type="text" placeholder="Enter Username"  required="" name="username"  data-url="componentsdata/users_username_value_exist/" data-loading-msg="Checking availability ..." data-available-msg="Available" data-unavailable-msg="Not available" class="form-control  ctrl-check-duplicate" />
                                            <div class="check-status"></div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="saldo_balance">Saldo Balance </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-saldo_balance-holder" class=" ">
                                            <input id="ctrl-saldo_balance" data-field="saldo_balance"  value="<?php  echo $data['saldo_balance']; ?>" type="number" placeholder="Enter Saldo Balance" step="0.1"  name="saldo_balance"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="plan_id">Plan Id </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-plan_id-holder" class=" ">
                                            <input id="ctrl-plan_id" data-field="plan_id"  value="<?php  echo $data['plan_id']; ?>" type="number" placeholder="Enter Plan Id" step="any"  name="plan_id"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input id="ctrl-code" data-field="code"  value="<?php  echo $data['code']; ?>" type="hidden" placeholder="Enter Code"  name="code"  class="form-control " />
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="ref_code">Ref Code </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-ref_code-holder" class=" ">
                                            <input id="ctrl-ref_code" data-field="ref_code"  value="<?php  echo $data['ref_code']; ?>" type="text" placeholder="Enter Ref Code"  name="ref_code"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="google_id">Google Id </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-google_id-holder" class=" ">
                                            <input id="ctrl-google_id" data-field="google_id"  value="<?php  echo $data['google_id']; ?>" type="text" placeholder="Enter Google Id"  name="google_id"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="verification_code">Verification Code </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-verification_code-holder" class=" ">
                                            <input id="ctrl-verification_code" data-field="verification_code"  value="<?php  echo $data['verification_code']; ?>" type="text" placeholder="Enter Verification Code"  name="verification_code"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="fcm">Fcm </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-fcm-holder" class=" ">
                                            <input id="ctrl-fcm" data-field="fcm"  value="<?php  echo $data['fcm']; ?>" type="text" placeholder="Enter Fcm"  name="fcm"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="pin">Pin </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-pin-holder" class=" ">
                                            <input id="ctrl-pin" data-field="pin"  value="<?php  echo $data['pin']; ?>" type="text" placeholder="Enter Pin"  name="pin"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="markup">Markup </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-markup-holder" class=" ">
                                            <input id="ctrl-markup" data-field="markup"  value="<?php  echo $data['markup']; ?>" type="text" placeholder="Enter Markup"  name="markup"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="status">Status </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-status-holder" class=" ">
                                            <input id="ctrl-status" data-field="status"  value="<?php  echo $data['status']; ?>" type="text" placeholder="Enter Status"  name="status"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="is_kyc">Is Kyc </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-is_kyc-holder" class=" ">
                                            <input id="ctrl-is_kyc" data-field="is_kyc"  value="<?php  echo $data['is_kyc']; ?>" type="text" placeholder="Enter Is Kyc"  name="is_kyc"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="is_outlet">Is Outlet </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-is_outlet-holder" class=" ">
                                            <input id="ctrl-is_outlet" data-field="is_outlet"  value="<?php  echo $data['is_outlet']; ?>" type="text" placeholder="Enter Is Outlet"  name="is_outlet"  class="form-control " />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="role_name">Role Name </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-role_name-holder" class=" ">
                                            <select  id="ctrl-role_name" data-field="role_name" name="role_name"  placeholder="Select a value ..."    class="form-select" >
                                            <option value="">Select a value ...</option>
                                            <?php
                                                $options = $comp_model->role_name_option_list() ?? [];
                                                foreach($options as $option){
                                                $value = $option->value;
                                                $label = $option->label ?? $value;
                                                $selected = ( $value == $data['role_name'] ? 'selected' : null );
                                            ?>
                                            <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                            <?php echo $label; ?>
                                            </option>
                                            <?php
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="role_id">Role Id </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div id="ctrl-role_id-holder" class=" ">
                                            <select  id="ctrl-role_id" data-field="role_id" name="role_id"  placeholder="Select a value ..."    class="form-select" >
                                            <option value="">Select a value ...</option>
                                            <?php
                                                $options = $comp_model->role_name_option_list() ?? [];
                                                foreach($options as $option){
                                                $value = $option->value;
                                                $label = $option->label ?? $value;
                                                $selected = ( $value == $data['role_id'] ? 'selected' : null );
                                            ?>
                                            <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                            <?php echo $label; ?>
                                            </option>
                                            <?php
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-ajax-status"></div>
                        <!--[form-content-end]-->
                        <!--[form-button-start]-->
                        <div class="form-group text-center">
                            <button class="btn btn-primary" type="submit">
                            Update
                            <i class="icon dripicons-direction"></i>
                            </button>
                        </div>
                        <!--[form-button-end]-->
                    </form>
                    <!--[form-end]-->
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
