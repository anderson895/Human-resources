<?php include'components/header.php'?>
<style>
  .loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 30px;
  height: 30px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
<?php 
$ascending = "ASC";
if(isset($_GET['f']))
{
    $ascending = $_GET['f'];
    if ($ascending == 'ASC' || $ascending == 'DESC') {
        $filter = $ascending;
    }else{
        $filter = "ASC";
    }
    $ascending = $filter;
}

$rows = $db->getAllJobPosting($ascending);
$jobCount = count($rows);

?>
<?php 
$recordsPerPage = 2; // Define how many records you want per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Get current page from URL, default to 1
$offset = ($page - 1) * $recordsPerPage; // Calculate the offset for the SQL query

$rows = $db->getPaginatedJobPosting($ascending, $offset, $recordsPerPage); // Fetch jobs with limit and offset
$totalJobs = $db->getTotalJobCount(); // Fetch the total number of jobs
$totalPages = ceil($totalJobs / $recordsPerPage); // Calculate total pages

?>

    <main>
        <!-- Hero Area Start-->
        <div class="slider-area ">
            <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="assets/img/hero/about.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap text-center">
                                <h2>Find your job</h2>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero Area End -->
        <!-- Job List Area Start -->
        <div class="job-listing-area pt-25 pb-120">
            <div class="container">
                <div class="row">
                    <!-- Left content -->
                    <div class="col-xl-3 col-lg-3 col-md-4">
                        <div class="row">
                            <div class="col-12">
                                    <div class="small-section-tittle2 mb-45">
                                   
                                </div>
                            </div>
                        </div>
                        <!-- Job Category Listing start -->
                        <div class="job-category-listing mb-50">
                            <!-- single one -->
                            <div class="single-listing">
                                <!-- select-Categories start -->
                                <div class="select-Categories ">
                                    <div class="small-section-tittle2">
                                        <h4>Job Type</h4>
                                    </div>
                                    <label class="container" for="full-time">Full Time
                                        <input type="checkbox" id="full-time">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container" for="part-time">Part Time
                                        <input type="checkbox" id="part-time" >
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container" for="remote">Remote
                                        <input type="checkbox" id="remote">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container" for="freelance">Freelance
                                        <input type="checkbox" id="freelance">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>

                                <!-- select-Categories End -->
                            </div>
                           
                            
                            
                        </div>
                        <!-- Job Category Listing End -->
                    </div>
                    <!-- Right content -->
                    <div class="col-xl-9 col-lg-9 col-md-8">
                        <!-- Featured_job_start -->
                        <section class="featured-job-area">
                            <div class="container">
                                <!-- Count of Job list Start -->
                                <div class="row flex justify-content-end ">
                                    <div class="col-lg-3">
                                        <div class="count-job mb-35 ">
                                            <!-- Select job items start -->
                                            <form action="" method="GET" class="select-job-items">
                                                <span class="text-nowrap">Sort by</span>
                                                <select name="f" class="w-100" onchange="this.form.submit()">
                                                    <option value="ASC" <?php echo $ascending === 'ASC' ? 'selected' : ''; ?>>Ascending</option>
                                                    <option value="DESC" <?php echo $ascending === 'DESC' ? 'selected' : ''; ?>>Descending</option>
                                                </select>
                                            </form>
                                            <!--  Select job items End-->
                                        </div>
                                    </div>
                                </div>
                                <!-- Count of Job list End -->



<?php
    $checker = "0";
if ($jobCount > 0) {
    foreach ($rows as $row) {
        $checker = "1";
        $id = htmlspecialchars($row['id']);
        $title = ($row['title']);
        $image = htmlspecialchars($row['image']);
        $description = ($row['description']);
        $location = htmlspecialchars($row['location']);
        $position = htmlspecialchars($row['position']);
        $datetime_created = htmlspecialchars($row['datetime_created']);

        // Convert datetime_created to DateTime object
        $createdDateTime = new DateTime($datetime_created);
        $currentDateTime = new DateTime();
        
        // Calculate the difference
        $interval = $currentDateTime->diff($createdDateTime);
        
        // Get the difference in hours
        $hoursAgo = $interval->days * 24 + $interval->h;

        echo '
        <div class="single-job-items mb-4" data-position="'. strtolower($position) .'">
            <div class="row g-0">
                <div class="col-md-4">
                    <a href="admin/uploads/job_posting/'.$image.'" data-lightbox="job-image" data-title="'. $title .'">
                        <img src="admin/uploads/job_posting/'.$image.'" class="img-fluid rounded-start" alt="job image" style="object-fit: cover; height: 100%; border-radius: 0.25rem;">
                    </a>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">'. $title .'</h5>
                        <p class="card-text"><small class="text-muted"><i class="fas fa-map-marker-alt"></i> '. $location .'</small></p>
                        <p class="card-text"><small class="text-muted"><i class="fas fa-calendar"></i> '.$hoursAgo.' hours ago</small></p>
                        <p class="card-text"><small class="text-muted"><i class="fas fa-clock"></i> '. $position .'</small></p>
                        <p data-bs-toggle="modal" data-bs-target="#detailModal" style="cursor:pointer;" data-description="'.$description.'" class="card-text btnDetail"><small class="text-muted">See more details</small></p>

                        <a href="#" data-bs-toggle="modal" data-bs-target="#jobModal" data-id="'. $id .'" class="btn  jobBtn">Apply Now</a>
                    </div>
                </div>
            </div>
        </div>
        ';
} 
} 
?>


<div style="<?php echo $checker == "0" ? 'display: block;' : 'display: none;'; ?>" class="alert alert-info" id="nojobalert" role="alert">No job openings available at the moment.</div>

                                
                            </div>
                          
                        </section>
                        <!-- Featured_job_end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Job List Area End -->
        <!-- Pagination Start -->
<div class="pagination-area pb-115 text-center">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="single-wrap d-flex justify-content-center">
                    <nav >
                        <ul class="pagination justify-content-start">
                            <?php if($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?f=<?php echo $ascending; ?>&page=<?php echo $page - 1; ?>">Previous</a>
                                </li>
                            <?php endif; ?>
                            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?f=<?php echo $ascending; ?>&page=<?php echo $i; ?>"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></a>
                                </li>
                            <?php endfor; ?>
                            <?php if($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?f=<?php echo $ascending; ?>&page=<?php echo $page + 1; ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Pagination End -->

    </main>


<!-- Modal -->
<div class="modal fade"  id="jobModal"  data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-1" id="jobModalLabel">Application</h3>
      </div>
      <div class="modal-body">
        <!-- Login Form -->
        <form id="jobForm" enctype="multipart/form-data">
          <div class="mb-3">
            <input type="text" name="application_id" id="application_id" hidden>
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email">
          </div>
        <hr>
          <div class="mb-3">
            <label for="name" class="form-label">First Name</label>
            <input type="text" name="fname" class="form-control" id="fname" placeholder="Enter your First Name">
          </div>

          <div class="mb-3">
            <label for="name" class="form-label">Middle Name</label>
            <input type="text" name="mname" class="form-control" id="mname" placeholder="Enter your Middle Name">
          </div>

          <div class="mb-3">
            <label for="name" class="form-label">Last Name</label>
            <input type="text" name="lname" class="form-control" id="lname" placeholder="Enter your Last Name">
          </div>

          <hr>

          <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" class="form-select mb-3" id="gender" >
                <option value="" selected>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
          </div>


          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="address" placeholder="Enter your Address">
          </div>
          
          <div class="mb-3">
            <label for="birthday" class="form-label">Birthday</label>
            <input type="date" name="birthday" class="form-control" id="birthday" placeholder="Enter your birthday">
          </div>

          <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="tel" name="phone" class="form-control" id="phone" placeholder="Enter your phone">
          </div>

          <hr>
          <div class="mb-3">
            <label for="name" class="form-label">Resume/CV</label>
            <input type="file" name="resume" class="form-control" id="resume">
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="submitApplication" class="btn head-btn1">Submit Application</button>
        <div id="spinner" class="loader d-none"></div>
    </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade"  id="detailModal"  data-bs-keyboard="false" tabindex="-1" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title fs-1" id="detailModalLabel">Job Details</h3>
      </div>
      <div class="modal-body">
        <p id="detailDescription"></p>
     
      </div>
      
    </div>
  </div>
</div>


 <!-- jQuery (required by Lightbox2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Lightbox2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

<!-- Lightbox2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<?php include'components/footer.php'?>
<script src="js/find_job.js"></script>

<script>
    $('.btnDetail').click(function(){
       var desc =  $(this).data('description');
       $('#detailModal #detailDescription').text(desc)
    })
</script>