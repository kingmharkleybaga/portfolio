<?php Session::check_session(); ?>
 
    <?php if( isset( $_SESSION ) && !empty( $_SESSION ) ) : ?>
      
       <div id="mySidenav" class="sidenav">
           <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
           <div class="row text-center">
               <div class="img-wrapper">
                   <img src="<?php Account::get_image(); ?>" alt="">
               </div>
               <h5><?php Account::get_name(); ?></h5>
               <div class="underline"></div>
           </div>
           
           <?php
                
                if($_SESSION['account_type'] == 'student') {
                    echo '<a href="profile.php"><i class="fa fa-user"></i> PROFILE</a>';
                    echo '<a href="journal.php"><i class="fa fa-book"></i> JOURNAL</a>';
                    echo '<a href="messages.php" class="messages-concerns"><i class="fa fa-comments-o"></i> MESSAGES/CONCERNS';
                    echo Message::count_notifications();
                    echo '</a>';
                } elseif($_SESSION['account_type'] == 'coordinator') {
                    echo '<a href="coordinator.php"><i class="fa fa-home"></i> HOME</a>';
                    echo '<a href="staff-profile.php"><i class="fa fa-user"></i> PROFILE</a>';
                    echo '<a href="enroll-student.php"><i class="fa fa-book"></i> REGISTRATION</a>';
                    echo '<a href="enrolled-students.php"><i class="fa fa-bookmark"></i> ENROLLED STUDENTS</a>';
                    echo '<a href="concerns.php"><i class="fa fa-bell"></i> MESSAGES/CONCERNS ( ';
                    echo Message::count_messages();
                    echo ' )</a>';
                } else {
                    echo '<a href="admin.php"><i class="fa fa-home"></i> HOME</a>';
                    echo '<a href="staff-profile.php"><i class="fa fa-user"></i> PROFILE</a>';
                    echo '<a href="coordinators.php"><i class="fa fa-users"></i> COORDINATORS</a>';
                    echo '<a href="concerns.php"><i class="fa fa-bell"></i> MESSAGES/CONCERNS ( ';
                    echo Message::count_all_messages();
                    echo ' )</a>';
                }
           ?>
           
           
           
           
           <a href="logout.php"><i class="fa fa-power-off"></i> LOGOUT</a>
        </div>
        <span style="font-size:30px;cursor:pointer;color:crimson" onclick="openNav()">&#9776; MENU</span>
    <script>
        function openNav() {
            
            if($(window).width() < 375) {
                document.getElementById("mySidenav").style.width = "100%";
            } else if($(window).width() < 768) {
                document.getElementById("mySidenav").style.width = "100%";
            } else if($(window).width() < 1024) {
                document.getElementById("mySidenav").style.width = "50%";
            } else if($(window).width() < 1400) {
                document.getElementById("mySidenav").style.width = "40%";
            } else {
                document.getElementById("mySidenav").style.width = "25%";
            }
            
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>
    <?php endif; ?>