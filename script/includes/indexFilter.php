<?php 
if ((isset($_GET['dtmBegin'])) AND isset($_GET['dtmEnd']) AND isset($_GET['searchInput']))
{
    $dtmBeginValue = $_GET['dtmBegin'];
    $dtmEndValue = $_GET['dtmEnd'];
    $searchInput = $_GET['searchInput'];
} else {
    $dtmBeginValue = date("d/m/Y");
    $dtmEndValue = date("d/m/Y");
    $searchInput = "";
}
?>

<form action="#" method = "GET" class="container-fluid mx-auto" style="width: 40rem;margin-top:5rem;" >
    <div class = "input-group">
        <input type="text" name="searchInput" value="<?php echo $searchInput ?>" class = "form-control">
        <div class="input-group-append">
            <input type="submit" value="Search" class="btn btn-info" style=" background: #11998e;
                background: -webkit-linear-gradient(to right, #11998e, #38ef7d);
                background: linear-gradient(to right, #11998e, #38ef7d);">
        </div>
    </div>
    
    <div class = "input-group  mt-3 mb-5 mx-auto justify-content-center">
        <div class="card bg-dark" style="width: 20rem;">
            <div class="card-header text-white bg-info">Date</div>
                <div class="card-body text-white">
                    <script type="text/javascript">
                        $('#sandbox-container .input-daterange').datepicker({
                            format: "yyyy/mm/dd",
                            todayBtn: "linked",
                            clearBtn: true,
                            forceParse: false,
                            autoclose: true,
                            todayHighlight: true
                        });
                    </script>
                    <div class="input-daterange input-group" id="sandbox-container" data-provide="datepicker">
                        <input type="text" class="input-sm form-control" name="dtmBegin" value="<?php echo $dtmBeginValue?>" required/>
                        <span class="bg-info font-weight-bold pr-3 pl-3"> TO </span>
                        <input type="text" class="input-sm form-control" name="dtmEnd" value="<?php echo $dtmEndValue?>" required/>
                    </div>
                </div>
        </div>
    </div>
</form>
