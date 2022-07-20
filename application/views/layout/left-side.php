<div class="col-md-3 <?php echo $this->enable_rtl ? 'right_col' : 'left_col'; ?>">
    <div class="<?php echo $this->enable_rtl ? 'right_col' : 'left_col'; ?> scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo site_url('dashboard/index'); ?>">
                <?php if ($this->global_setting->brand_name) { ?>
                    <span <?php if (str_word_count($this->global_setting->brand_name) == 1) {
                                echo 'style="margin-top: 30px;"';
                            }  ?>>
                        <?php echo $this->global_setting->brand_name; ?>
                    </span>
                <?php } else { ?>
                    <span>HamroSchool</span>
                <?php } ?>

                <?php if ($this->global_setting->brand_logo) { ?>
                    <img class="logo" src="<?php echo UPLOAD_PATH . 'logo/' . $this->global_setting->brand_logo; ?>" style="max-width: 65px;" alt="">
                <?php } else { ?>
                    <img class="logo" src="<?php echo IMG_URL; ?>/sms-logo-50.png" alt="">
                <?php } ?>
            </a>
        </div>
        <div class="clearfix" style=""></div>
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <?php
                if ($this->session->userdata('role_id') != SUPER_ADMIN) {
                    $classes = get_classes($this->session->userdata('school_id'));
                }
                if ($this->session->userdata('role_id') == GUARDIAN) {
                    $guardian_class_data = get_guardian_access_data('class');
                }
                ?>

                <ul class="nav side-menu">
                    <li><a href="<?php echo site_url('dashboard/index'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('dashboard'); ?></a> </li>

                    <?php if ($this->session->userdata('role_id') != SUPER_ADMIN) { ?>
                        <?php if (has_permission(VIEW, 'setting', 'setting') || has_permission(VIEW, 'setting', 'payment')  || has_permission(VIEW, 'setting', 'sms') || has_permission(VIEW, 'setting', 'openinghour')) { ?>
                            <li><a><i class="fa fa-gears"></i> <?php echo $this->lang->line('setting'); ?> <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <?php if (has_permission(VIEW, 'setting', 'setting')) { ?>
                                        <li><a href="<?php echo site_url('setting/index'); ?>"><?php echo $this->lang->line('school_setting'); ?></a></li>
                                    <?php } ?>
                                    <?php if (has_permission(VIEW, 'setting', 'payment')) { ?>
                                        <li><a href="<?php echo site_url('setting/payment/index'); ?>"><?php echo $this->lang->line('payment_setting'); ?></a></li>
                                    <?php } ?>
                                    <?php if (has_permission(VIEW, 'setting', 'sms')) { ?>
                                        <li><a href="<?php echo site_url('setting/sms/index'); ?>"><?php echo $this->lang->line('sms_setting'); ?></a></li>
                                    <?php } ?>
                                    <?php if (has_permission(VIEW, 'setting', 'emailsetting')) { ?>
                                        <li><a href="<?php echo site_url('setting/emailsetting/index'); ?>"><?php echo $this->lang->line('email_setting'); ?></a></li>
                                    <?php } ?>
                                    <?php if (has_permission(VIEW, 'setting', 'openinghour')) { ?>
                                        <li><a href="<?php echo site_url('setting/openinghour/index'); ?>"><?php echo $this->lang->line('opening_hour'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                    <?php } ?>



                    <?php if (has_permission(VIEW, 'theme', 'theme')) { ?>
                        <li class="hidden"><a href="<?php echo site_url('theme/index'); ?>"><i class="fa fa-cubes"></i> <?php echo $this->lang->line('theme'); ?></a></li>
                    <?php } ?>

                    <?php if (has_permission(VIEW, 'language', 'language')) { ?>
                        <li class=""><a href="<?php echo site_url('language/index'); ?>"><i class="fa fa-language"></i> <?php echo $this->lang->line('language'); ?></a></li>
                    <?php } ?>

                    <?php
                    if (
                        has_permission(VIEW, 'administrator', 'setting') ||
                        has_permission(VIEW, 'administrator', 'school') ||
                        has_permission(VIEW, 'administrator', 'payment') ||
                        has_permission(VIEW, 'administrator', 'sms') ||
                        has_permission(VIEW, 'administrator', 'year') ||
                        has_permission(VIEW, 'administrator', 'role') ||
                        has_permission(VIEW, 'administrator', 'permission') ||
                        has_permission(VIEW, 'administrator', 'user') ||
                        has_permission(VIEW, 'administrator', 'usercredential') ||
                        has_permission(VIEW, 'administrator', 'superadmin') ||
                        has_permission(EDIT, 'administrator', 'password') ||
                        has_permission(VIEW, 'administrator', 'backup') ||
                        has_permission(VIEW, 'administrator', 'activitylog') ||
                        has_permission(VIEW, 'administrator', 'feedback')
                    ) { ?>
                        <li><a><i class="bi bi-person"></i> <?php echo $this->lang->line('administrator'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'administrator', 'setting')) { ?>
                                    <li><a href="<?php echo site_url('administrator/setting/index'); ?>"> <?php echo $this->lang->line('general_setting'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'administrator', 'school')) { ?>
                                    <li><a href="<?php echo site_url('administrator/school/index'); ?>"> <?php echo $this->lang->line('manage_school'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'administrator', 'payment')) { ?>
                                    <li><a href="<?php echo site_url('administrator/payment/index'); ?>"><?php echo $this->lang->line('payment_setting'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'administrator', 'sms')) { ?>
                                    <li><a href="<?php echo site_url('administrator/sms/index'); ?>"><?php echo $this->lang->line('sms_setting'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'administrator', 'emailsetting')) { ?>
                                    <li><a href="<?php echo site_url('administrator/emailsetting/index'); ?>"><?php echo $this->lang->line('email_setting'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'administrator', 'year')) { ?>
                                    <li><a href="<?php echo site_url('administrator/year/index'); ?>"> <?php echo $this->lang->line('academic_year'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'administrator', 'role')) { ?>
                                    <li><a href="<?php echo site_url('administrator/role/index'); ?>"> <?php echo $this->lang->line('user_role'); ?> (ACL)</a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'administrator', 'permission')) { ?>
                                    <li><a href="<?php echo site_url('administrator/permission/index'); ?>"><?php echo $this->lang->line('role_permission'); ?> (ACL)</a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'administrator', 'superadmin')) { ?>
                                    <li><a href="<?php echo site_url('administrator/superadmin/index'); ?>"> <?php echo $this->lang->line('manage_super_admin'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'administrator', 'user')) { ?>
                                    <li><a href="<?php echo site_url('administrator/user/index'); ?>"><?php echo $this->lang->line('manage_user'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(EDIT, 'administrator', 'password')) { ?>
                                    <li><a href="<?php echo site_url('administrator/password/index'); ?>"><?php echo $this->lang->line('reset_user_password'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(EDIT, 'administrator', 'username')) { ?>
                                    <li><a href="<?php echo site_url('administrator/username/index'); ?>"><?php echo $this->lang->line('reset_username'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'administrator', 'usercredential')) { ?>
                                    <li><a href="<?php echo site_url('administrator/usercredential/index'); ?>"><?php echo $this->lang->line('user_credential'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'administrator', 'activitylog')) { ?>
                                    <li><a href="<?php echo site_url('administrator/activitylog/index'); ?>"><?php echo $this->lang->line('activity_log'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'administrator', 'feedback')) { ?>
                                    <li><a href="<?php echo site_url('administrator/feedback/index'); ?>"><?php echo $this->lang->line('manage_feedback'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'administrator', 'backup')) { ?>
                                    <li><a href="<?php echo site_url('administrator/backup/index'); ?>"><?php echo $this->lang->line('backup_database'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'administrator', 'openinghour')) { ?>
                                    <li><a href="<?php echo site_url('administrator/openinghour'); ?>"><?php echo $this->lang->line('opening_hour'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if (has_permission(VIEW, 'administrator', 'emailtemplate') || has_permission(VIEW, 'administrator', 'smstemplate')) { ?>
                        <li><a><i class="fa fa-tags"></i> <?php echo $this->lang->line('template'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'administrator', 'smstemplate')) { ?>
                                    <li><a href="<?php echo site_url('administrator/smstemplate/index'); ?>"><?php echo $this->lang->line('sms_template'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'administrator', 'emailtemplate')) { ?>
                                    <li><a href="<?php echo site_url('administrator/emailtemplate/index'); ?>"><?php echo $this->lang->line('email_template'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (
                        has_permission(VIEW, 'frontoffice', 'purpose') ||
                        has_permission(VIEW, 'frontoffice', 'visitor') ||
                        has_permission(VIEW, 'frontoffice', 'calllog') ||
                        has_permission(VIEW, 'frontoffice', 'dispatch') ||
                        has_permission(VIEW, 'frontoffice', 'receive') ||
                        has_permission(VIEW, 'administrator', 'frontoffice')
                    ) { ?>
                        <li><a><i class="bi bi-building"></i> <?php echo $this->lang->line('front_office'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'frontoffice', 'purpose')) { ?>
                                    <li><a href="<?php echo site_url('frontoffice/purpose/index'); ?>"><?php echo $this->lang->line('visitor_purpose'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'frontoffice', 'visitor')) { ?>
                                    <li><a href="<?php echo site_url('frontoffice/visitor/index'); ?>"><?php echo $this->lang->line('visitor_info'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'frontoffice', 'calllog')) { ?>
                                    <li><a href="<?php echo site_url('frontoffice/calllog/index'); ?>"><?php echo $this->lang->line('call_log'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'frontoffice', 'dispatch')) { ?>
                                    <li><a href="<?php echo site_url('frontoffice/dispatch/index'); ?>"><?php echo $this->lang->line('postal_dispatch'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'frontoffice', 'receive')) { ?>
                                    <li><a href="<?php echo site_url('frontoffice/receive/index'); ?>"><?php echo $this->lang->line('postal_receive'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (has_permission(VIEW, 'hrm', 'designation') || has_permission(VIEW, 'hrm', 'employee')) { ?>
                        <li><a><i class="bi bi-people-fill"></i> <?php echo $this->lang->line('human_resource'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'hrm', 'designation')) { ?>
                                    <li><a href="<?php echo site_url('hrm/designation/index'); ?>"><?php echo $this->lang->line('manage_designation'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'hrm', 'employee')) { ?>
                                    <li><a href="<?php echo site_url('hrm/employee/index'); ?>"><?php echo $this->lang->line('manage_employee'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (
                        has_permission(VIEW, 'teacher', 'teacher') ||
                        has_permission(VIEW, 'teacher', 'department') ||
                        has_permission(VIEW, 'teacher', 'lecture') ||
                        has_permission(VIEW, 'teacher', 'rating')
                    ) { ?>
                        <li><a><i class="bi bi-person-workspace"></i> <?php echo $this->lang->line('teacher'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'teacher', 'department')) { ?>
                                    <li><a href="<?php echo site_url('teacher/department/index'); ?>"><?php echo $this->lang->line('department'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'teacher', 'teacher')) { ?>
                                    <li><a href="<?php echo site_url('teacher/index'); ?>"><?php echo $this->lang->line('manage_teacher'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'teacher', 'lecture')) { ?>
                                    <li><a href="<?php echo site_url('teacher/lecture/index'); ?>"><?php echo $this->lang->line('class_lecture'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'teacher', 'rating') && $this->session->userdata('role_id') == STUDENT) { ?>
                                    <li><a href="<?php echo site_url('teacher/rating/index'); ?>"><?php echo $this->lang->line('rating'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'teacher', 'rating') && $this->session->userdata('role_id') != STUDENT) { ?>
                                    <li><a href="<?php echo site_url('teacher/rating/manage'); ?>"><?php echo $this->lang->line('rating'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if (has_permission(VIEW, 'leave', 'leave') || has_permission(VIEW, 'leave', 'type')) { ?>
                        <li><a><i class="bi bi-bell"></i> <?php echo $this->lang->line('manage_leave'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'leave', 'type')) { ?>
                                    <li><a href="<?php echo site_url('leave/type/index'); ?>"><?php echo $this->lang->line('leave_type'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'leave', 'application')) { ?>
                                    <li><a href="<?php echo site_url('leave/application/index'); ?>"><?php echo $this->lang->line('leave_application'); ?> </a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'leave', 'waiting')) { ?>
                                    <li><a href="<?php echo site_url('leave/waiting/index'); ?>"><?php echo $this->lang->line('waiting_application'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'leave', 'approve')) { ?>
                                    <li><a href="<?php echo site_url('leave/approve/index'); ?>"><?php echo $this->lang->line('approved_application'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'leave', 'decline')) { ?>
                                    <li><a href="<?php echo site_url('leave/decline/index'); ?>"><?php echo $this->lang->line('declined_application'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if (
                        has_permission(VIEW, 'academic', 'classes') ||
                        has_permission(VIEW, 'academic', 'section') ||
                        has_permission(VIEW, 'academic', 'subject') ||
                        has_permission(VIEW, 'academic', 'syllabus') ||
                        has_permission(VIEW, 'academic', 'material') ||
                        has_permission(VIEW, 'academic', 'liveclass') ||
                        has_permission(VIEW, 'academic', 'assignment') ||
                        has_permission(VIEW, 'academic', 'submission')
                    ) { ?>
                        <li><a><i class="bi bi-bank"></i> <?php echo $this->lang->line('academic'); ?><span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'academic', 'classes')) { ?>
                                    <li><a href="<?php echo site_url('academic/classes/index'); ?>"><?php echo $this->lang->line('class'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'academic', 'section')) { ?>
                                    <li><a href="<?php echo site_url('academic/section/index'); ?>"><?php echo $this->lang->line('section'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'academic', 'subject')) { ?>
                                    <li><a href="<?php echo site_url('academic/subject/index'); ?>"><?php echo $this->lang->line('subject'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'academic', 'syllabus')) { ?>
                                    <li><a href="<?php echo site_url('academic/syllabus/index'); ?>"><?php echo $this->lang->line('syllabus'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'academic', 'material')) { ?>
                                    <li><a href="<?php echo site_url('academic/material/index'); ?>"><?php echo $this->lang->line('material'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'academic', 'liveclass')) { ?>
                                    <li><a href="<?php echo site_url('academic/liveclass/index'); ?>"><?php echo $this->lang->line('live_class'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'academic', 'assignment')) { ?>
                                    <li><a href="<?php echo site_url('academic/assignment/index'); ?>"><?php echo $this->lang->line('assignment'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'academic', 'submission')) { ?>
                                    <li><a href="<?php echo site_url('academic/submission/index'); ?>"><?php echo $this->lang->line('submission'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if (
                        has_permission(VIEW, 'lessonplan', 'lessonplan') ||
                        has_permission(VIEW, 'lessonplan', 'lesson') ||
                        has_permission(VIEW, 'lessonplan', 'status') ||
                        has_permission(VIEW, 'lessonplan', 'topic')
                    ) { ?>
                        <li><a><i class="fa fa-bars"></i> <?php echo $this->lang->line('lesson_plan'); ?><span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'lessonplan', 'lesson')) { ?>
                                    <li><a href="<?php echo site_url('lessonplan/lesson/index'); ?>"><?php echo $this->lang->line('lesson'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'lessonplan', 'topic')) { ?>
                                    <li><a href="<?php echo site_url('lessonplan/topic/index'); ?>"><?php echo $this->lang->line('topic'); ?></a></li>
                                <?php } ?>

                                <?php if (has_permission(VIEW, 'lessonplan', 'timeline')) { ?>
                                    <li><a href="<?php echo site_url('lessonplan/timeline'); ?>"><?php echo $this->lang->line('lesson_time_line'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'lessonplan', 'status')) { ?>
                                    <li><a href="<?php echo site_url('lessonplan/status'); ?>"><?php echo $this->lang->line('lesson_status'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'lessonplan', 'lessonplan')) { ?>
                                    <li><a href="<?php echo site_url('lessonplan/index'); ?>"><?php echo $this->lang->line('lesson_plan'); ?></a></li>
                                <?php } ?>

                            </ul>
                        </li>
                    <?php } ?>


                    <?php if (has_permission(VIEW, 'academic', 'routine')) { ?>
                        <li> <a href="<?php echo site_url('academic/routine/index'); ?>"> <i class="fa fa-clock-o"></i><?php echo $this->lang->line('class_routine'); ?></a></li>
                    <?php } ?>

                    <?php if (has_permission(VIEW, 'guardian', 'guardian')) { ?>
                        <li><a href="<?php echo site_url('guardian/index'); ?>"><i class="fa fa-paw"></i> <?php echo $this->lang->line('guardian'); ?></a> </li>
                    <?php } ?>


                    <?php if (
                        has_permission(VIEW, 'student', 'type') ||
                        has_permission(ADD, 'student', 'student') ||
                        has_permission(ADD, 'student', 'bulk') ||
                        has_permission(ADD, 'student', 'admission') ||
                        has_permission(ADD, 'student', 'activity')
                    ) { ?>

                        <li><a><i class="bi bi-person-badge"></i> <?php echo $this->lang->line('manage_student'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'student', 'type')) { ?>
                                    <li><a href="<?php echo site_url('student/type/index'); ?>"> <?php echo $this->lang->line('student_type'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'student', 'student')) { ?>
                                    <li><a href="<?php echo site_url('student/index'); ?>"><?php echo $this->lang->line('student_list'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(ADD, 'student', 'student')) { ?>
                                    <li><a href="<?php echo site_url('student/add'); ?>"> <?php echo $this->lang->line('admit_student'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(ADD, 'student', 'bulk')) { ?>
                                    <li><a href="<?php echo site_url('student/bulk/add'); ?>"> <?php echo $this->lang->line('bulk_admission'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'student', 'admission')) { ?>
                                    <li><a href="<?php echo site_url('student/admission/index'); ?>"> <?php echo $this->lang->line('online_admission'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'student', 'activity')) { ?>
                                    <li><a href="<?php echo site_url('student/activity/index'); ?>"> <?php echo $this->lang->line('student_activity'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>

                    <?php } ?>



                    <?php if (
                        has_permission(VIEW, 'attendance', 'student') ||
                        has_permission(VIEW, 'attendance', 'teacher') ||
                        has_permission(VIEW, 'attendance', 'employee') ||
                        has_permission(VIEW, 'attendance', 'absentemail') ||
                        has_permission(VIEW, 'attendance', 'absentsms')
                    ) { ?>

                        <li><a><i class="bi bi-ui-checks"></i> <?php echo $this->lang->line('attendance'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'attendance', 'student')) { ?>
                                    <?php if ($this->session->userdata('role_id') == GUARDIAN) { ?>
                                        <li><a href="<?php echo site_url('attendance/student/guardian'); ?>"><?php echo $this->lang->line('student_attendance'); ?></a></li>
                                    <?php } else { ?>
                                        <li><a href="<?php echo site_url('attendance/student/index'); ?>"><?php echo $this->lang->line('student_attendance'); ?></a></li>
                                    <?php } ?>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'attendance', 'teacher')) { ?>
                                    <li><a href="<?php echo site_url('attendance/teacher/index'); ?>"><?php echo $this->lang->line('teacher_attendance'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'attendance', 'employee')) { ?>
                                    <li><a href="<?php echo site_url('attendance/employee/index'); ?>"><?php echo $this->lang->line('employee_attendance'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'attendance', 'absentemail')) { ?>
                                    <li><a href="<?php echo site_url('attendance/absentemail/index'); ?>"><?php echo $this->lang->line('absent_email'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'attendance', 'absentsms')) { ?>
                                    <li><a href="<?php echo site_url('attendance/absentsms/index'); ?>"><?php echo $this->lang->line('absent_sms'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (
                        has_permission(VIEW, 'card', 'idsetting') ||
                        has_permission(VIEW, 'card', 'schoolidsetting') ||
                        has_permission(VIEW, 'card', 'admitsetting') ||
                        has_permission(VIEW, 'card', 'schooladmitsetting') ||
                        has_permission(VIEW, 'card', 'teacher') ||
                        has_permission(VIEW, 'card', 'employee') ||
                        has_permission(VIEW, 'card', 'student') ||
                        has_permission(VIEW, 'card', 'admit')
                    ) { ?>

                        <li><a><i class="bi bi-qr-code-scan"></i> <?php echo $this->lang->line('generate_card'); ?><span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'card', 'idsetting')) { ?>
                                    <li><a href="<?php echo site_url('card/idsetting/index'); ?>"><?php echo $this->lang->line('id_card_setting'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'card', 'admitsetting')) { ?>
                                    <li><a href="<?php echo site_url('card/admitsetting/index'); ?>"><?php echo $this->lang->line('admit_card_setting'); ?></a></li>
                                <?php } ?>

                                <?php if (has_permission(VIEW, 'card', 'schoolidsetting')) { ?>
                                    <li><a href="<?php echo site_url('card/schoolidsetting/index'); ?>"><?php echo $this->lang->line('id_card_setting'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'card', 'schooladmitsetting')) { ?>
                                    <li><a href="<?php echo site_url('card/schooladmitsetting/index'); ?>"><?php echo $this->lang->line('admit_card_setting'); ?></a></li>
                                <?php } ?>

                                <?php if (has_permission(VIEW, 'card', 'teacher')) { ?>
                                    <li><a href="<?php echo site_url('card/teacher/index'); ?>"><?php echo $this->lang->line('teacher_id_card'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'card', 'employee')) { ?>
                                    <li><a href="<?php echo site_url('card/employee/index'); ?>"><?php echo $this->lang->line('employee_id_card'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'card', 'student')) { ?>
                                    <li><a href="<?php echo site_url('card/student/index'); ?>"><?php echo $this->lang->line('student_id_card'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'card', 'admit')) { ?>
                                    <li><a href="<?php echo site_url('card/admit/index'); ?>"><?php echo $this->lang->line('student_admit_card'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if (
                        has_permission(VIEW, 'onlineexam', 'instruction') ||
                        has_permission(VIEW, 'onlineexam', 'question') ||
                        has_permission(VIEW, 'onlineexam', 'onlineexam') ||
                        has_permission(VIEW, 'onlineexam', 'takeexam')
                    ) { ?>
                        <li><a><i class="bi bi-pc-display-horizontal"></i> <?php echo $this->lang->line('online_exam'); ?><span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'onlineexam', 'instruction')) { ?>
                                    <li><a href="<?php echo site_url('onlineexam/instruction/index'); ?>"><?php echo $this->lang->line('instruction'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'onlineexam', 'question')) { ?>
                                    <li><a href="<?php echo site_url('onlineexam/question/index'); ?>"><?php echo $this->lang->line('question_bank'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'onlineexam', 'onlineexam')) { ?>
                                    <li><a href="<?php echo site_url('onlineexam/index'); ?>"><?php echo $this->lang->line('online_exam'); ?></a></li>
                                <?php } ?>

                                <?php if ($this->session->userdata('role_id') == STUDENT) { ?>
                                    <?php if (has_permission(VIEW, 'onlineexam', 'takeexam')) { ?>
                                        <li><a href="<?php echo site_url('onlineexam/takeexam/index'); ?>"><?php echo $this->lang->line('take_exam'); ?></a></li>
                                    <?php } ?>
                                <?php } ?>

                                <?php if (has_permission(VIEW, 'onlineexam', 'takeexam')) { ?>
                                    <li><a href="<?php echo site_url('onlineexam/takeexam/result'); ?>"><?php echo $this->lang->line('exam_result'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (
                        has_permission(VIEW, 'exam', 'grade') ||
                        has_permission(VIEW, 'exam', 'exam')
                    ) { ?>
                        <li><a><i class="bi bi-mortarboard"></i> <?php echo $this->lang->line('manage_exam'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'exam', 'grade')) { ?>
                                    <li><a href="<?php echo site_url('exam/grade/index'); ?>"><?php echo $this->lang->line('exam_grade'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'exam', 'exam')) { ?>
                                    <li><a href="<?php echo site_url('exam/index'); ?>"><?php echo $this->lang->line('exam_term'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'exam', 'schedule')) { ?>
                                    <li><a href="<?php echo site_url('exam/schedule/index'); ?>"><?php echo $this->lang->line('schedule'); ?></a></li>
                                <?php } ?>

                                <?php if (has_permission(VIEW, 'exam', 'suggestion')) { ?>
                                    <li><a href="<?php echo site_url('exam/suggestion/index'); ?>"><?php echo $this->lang->line('suggestion'); ?></a></li>
                                <?php } ?>

                                <?php if (has_permission(VIEW, 'exam', 'attendance')) { ?>
                                    <li><a href="<?php echo site_url('exam/attendance/index'); ?>"><?php echo $this->lang->line('attendance'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (
                        has_permission(VIEW, 'exam', 'mark') ||
                        has_permission(VIEW, 'exam', 'examresult') ||
                        has_permission(VIEW, 'exam', 'finalresult') ||
                        has_permission(VIEW, 'exam', 'meritlist') ||
                        has_permission(VIEW, 'exam', 'marksheet') ||
                        has_permission(VIEW, 'exam', 'resultcard') ||
                        has_permission(VIEW, 'exam', 'text') ||
                        has_permission(VIEW, 'exam', 'mail') ||
                        has_permission(VIEW, 'exam', 'resultemail') ||
                        has_permission(VIEW, 'exam', 'resultsms')
                    ) { ?>
                        <li><a><i class="bi bi-file-pdf"></i> <?php echo $this->lang->line('exam_mark'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'exam', 'mark')) { ?>
                                    <li><a href="<?php echo site_url('exam/mark/index'); ?>"><?php echo $this->lang->line('manage_mark'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'exam', 'examresult')) { ?>
                                    <li><a href="<?php echo site_url('exam/examresult/index'); ?>"><?php echo $this->lang->line('exam_term_result'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'exam', 'finalresult')) { ?>
                                    <li><a href="<?php echo site_url('exam/finalresult/index'); ?>"><?php echo $this->lang->line('exam_final_result'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'exam', 'meritlist')) { ?>
                                    <li><a href="<?php echo site_url('exam/meritlist/index'); ?>"><?php echo $this->lang->line('merit_list'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'exam', 'marksheet')) { ?>
                                    <li><a href="<?php echo site_url('exam/marksheet/index'); ?>"><?php echo $this->lang->line('mark_sheet'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'exam', 'resultcard')) { ?>
                                    <li><a href="<?php echo site_url('exam/resultcard/index'); ?>"><?php echo $this->lang->line('result_card'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'exam', 'mail')) { ?>
                                    <li><a href="<?php echo site_url('exam/mail/index'); ?>"><?php echo $this->lang->line('mark_send_by_email'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'exam', 'text')) { ?>
                                    <li><a href="<?php echo site_url('exam/text/index'); ?>"><?php echo $this->lang->line('mark_send_by_sms'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'exam', 'resultemail')) { ?>
                                    <li><a href="<?php echo site_url('exam/resultemail/index'); ?>"><?php echo $this->lang->line('result_send_by_email'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'exam', 'resultsms')) { ?>
                                    <li><a href="<?php echo site_url('exam/resultsms/index'); ?>"><?php echo $this->lang->line('result_send_by_sms'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (has_permission(VIEW, 'academic', 'promotion')) { ?>
                        <li><a href="<?php echo site_url('academic/promotion'); ?>"><i class="fa fa-mail-forward"></i><?php echo $this->lang->line('promotion'); ?></a></li>
                    <?php } ?>

                    <?php if (has_permission(VIEW, 'certificate', 'certificate') || has_permission(VIEW, 'certificate', 'type')) { ?>
                        <li><a><i class="bi bi-credit-card-2-front"></i> <?php echo $this->lang->line('certificate'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'certificate', 'type')) { ?>
                                    <li><a href="<?php echo site_url('certificate/type/index'); ?>"><?php echo $this->lang->line('certificate_type'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'certificate', 'certificate')) { ?>
                                    <li><a href="<?php echo site_url('certificate/index'); ?>"><?php echo $this->lang->line('generate_certificate'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if (
                        has_permission(VIEW, 'inventory', 'supplier') ||
                        has_permission(VIEW, 'inventory', 'warehouse') ||
                        has_permission(VIEW, 'inventory', 'category') ||
                        has_permission(VIEW, 'inventory', 'product') ||
                        has_permission(VIEW, 'inventory', 'purchase') ||
                        has_permission(VIEW, 'inventory', 'sale') ||
                        has_permission(VIEW, 'inventory', 'issue')
                    ) { ?>
                        <li><a><i class="bi bi-inboxes"></i> <?php echo $this->lang->line('inventory'); ?><span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'inventory', 'supplier')) { ?>
                                    <li><a href="<?php echo site_url('inventory/supplier/index'); ?>"><?php echo $this->lang->line('supplier'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'inventory', 'warehouse')) { ?>
                                    <li><a href="<?php echo site_url('inventory/warehouse/index'); ?>"><?php echo $this->lang->line('warehouse'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'inventory', 'category')) { ?>
                                    <li><a href="<?php echo site_url('inventory/category/index'); ?>"><?php echo $this->lang->line('category'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'inventory', 'product')) { ?>
                                    <li><a href="<?php echo site_url('inventory/product/index'); ?>"><?php echo $this->lang->line('product'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'inventory', 'purchase')) { ?>
                                    <li><a href="<?php echo site_url('inventory/purchase/index'); ?>"><?php echo $this->lang->line('purchase'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'inventory', 'sale')) { ?>
                                    <li><a href="<?php echo site_url('inventory/sale/index'); ?>"><?php echo $this->lang->line('sale'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'inventory', 'issue')) { ?>
                                    <li><a href="<?php echo site_url('inventory/issue/index'); ?>"><?php echo $this->lang->line('issue'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (
                        has_permission(VIEW, 'asset', 'vendor') ||
                        has_permission(VIEW, 'asset', 'store') ||
                        has_permission(VIEW, 'asset', 'category') ||
                        has_permission(VIEW, 'asset', 'item') ||
                        has_permission(VIEW, 'asset', 'purchase') ||
                        has_permission(VIEW, 'asset', 'issue')
                    ) { ?>
                        <li><a><i class="bi bi-box2-heart"></i> <?php echo $this->lang->line('asset_management'); ?><span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'asset', 'vendor')) { ?>
                                    <li><a href="<?php echo site_url('asset/vendor/index'); ?>"><?php echo $this->lang->line('vendor'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'asset', 'store')) { ?>
                                    <li><a href="<?php echo site_url('asset/store/index'); ?>"><?php echo $this->lang->line('store'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'asset', 'category')) { ?>
                                    <li><a href="<?php echo site_url('asset/category/index'); ?>"><?php echo $this->lang->line('category'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'asset', 'item')) { ?>
                                    <li><a href="<?php echo site_url('asset/item/index'); ?>"><?php echo $this->lang->line('item'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'asset', 'purchase')) { ?>
                                    <li><a href="<?php echo site_url('asset/purchase/index'); ?>"><?php echo $this->lang->line('purchase'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'asset', 'issue')) { ?>
                                    <li><a href="<?php echo site_url('asset/issue/index'); ?>"><?php echo $this->lang->line('issue'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if (
                        has_permission(VIEW, 'library', 'book') ||
                        has_permission(VIEW, 'library', 'member') ||
                        has_permission(VIEW, 'library', 'issue') ||
                        has_permission(VIEW, 'library', 'ebook')
                    ) { ?>
                        <li><a><i class="bi bi-journal-bookmark-fill"></i> <?php echo $this->lang->line('library'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'library', 'book')) { ?>
                                    <li><a href="<?php echo site_url('library/book/index'); ?>"><?php echo $this->lang->line('book'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'library', 'member')) { ?>
                                    <li><a href="<?php echo site_url('library/member/index'); ?>"><?php echo $this->lang->line('library_member'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'library', 'issue')) { ?>
                                    <li><a href="<?php echo site_url('library/issue/index'); ?>"><?php echo $this->lang->line('issue_and_return'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'library', 'ebook')) { ?>
                                    <li><a href="<?php echo site_url('library/ebook/index'); ?>"><?php echo $this->lang->line('e_book'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (
                        has_permission(VIEW, 'transport', 'vehicle') ||
                        has_permission(VIEW, 'transport', 'route') ||
                        has_permission(VIEW, 'transport', 'member')
                    ) { ?>
                        <li><a><i class="bi bi-truck"></i> <?php echo $this->lang->line('transport'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'transport', 'vehicle')) { ?>
                                    <li><a href="<?php echo site_url('transport/vehicle/index'); ?>"><?php echo $this->lang->line('vehicle'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'transport', 'route')) { ?>
                                    <li><a href="<?php echo site_url('transport/route/index'); ?>"><?php echo $this->lang->line('transport_route'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'transport', 'member')) { ?>
                                    <li><a href="<?php echo site_url('transport/member/index'); ?>"><?php echo $this->lang->line('transport_member'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (
                        has_permission(VIEW, 'hostel', 'hostel') ||
                        has_permission(VIEW, 'hostel', 'room') ||
                        has_permission(VIEW, 'hostel', 'member')
                    ) { ?>
                        <li><a><i class="bi bi-house-heart"></i> <?php echo $this->lang->line('hostel'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'hostel', 'hostel')) { ?>
                                    <li><a href="<?php echo site_url('hostel/index'); ?>"><?php echo $this->lang->line('manage_hostel'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'hostel', 'room')) { ?>
                                    <li><a href="<?php echo site_url('hostel/room/index'); ?>"><?php echo $this->lang->line('manage_room'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'hostel', 'member')) { ?>
                                    <li><a href="<?php echo site_url('hostel/member/index'); ?>"><?php echo $this->lang->line('hostel_member'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (has_permission(VIEW, 'message', 'message')) { ?>
                        <li><a href="<?php echo site_url('message/inbox'); ?>"><i class="bi bi-chat-square-text"></i> <?php echo $this->lang->line('message'); ?></a></li>
                    <?php } ?>

                    <?php if (has_permission(VIEW, 'message', 'mail') || has_permission(VIEW, 'message', 'text')) { ?>
                        <li><a><i class="bi bi-envelope-paper"></i> <?php echo $this->lang->line('mail_and_sms'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'message', 'mail')) { ?>
                                    <li><a href="<?php echo site_url('message/mail/index'); ?>"><?php echo $this->lang->line('email'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'message', 'text')) { ?>
                                    <li><a href="<?php echo site_url('message/text/index'); ?>"><?php echo $this->lang->line('sms'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (has_permission(VIEW, 'complain', 'complain') || has_permission(VIEW, 'complain', 'type')) { ?>
                        <li><a><i class="bi bi-chat-right-quote"></i> <?php echo $this->lang->line('complain'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'complain', 'type')) { ?>
                                    <li><a href="<?php echo site_url('complain/type/index'); ?>"><?php echo $this->lang->line('complain_type'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'complain', 'complain')) { ?>
                                    <li><a href="<?php echo site_url('complain/index'); ?>"><?php echo $this->lang->line('manage_complain'); ?> </a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (
                        has_permission(VIEW, 'announcement', 'notice') ||
                        has_permission(VIEW, 'announcement', 'news') ||
                        has_permission(VIEW, 'announcement', 'holiday')
                    ) { ?>
                        <li><a><i class="fa fa-bullhorn"></i> <?php echo $this->lang->line('announcement'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'announcement', 'notice')) { ?>
                                    <li><a href="<?php echo site_url('announcement/notice/index'); ?>"><?php echo $this->lang->line('notice'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'announcement', 'news')) { ?>
                                    <li><a href="<?php echo site_url('announcement/news/index'); ?>"><?php echo $this->lang->line('news'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'announcement', 'holiday')) { ?>
                                    <li><a href="<?php echo site_url('announcement/holiday/index'); ?>"><?php echo $this->lang->line('holiday'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if (
                        has_permission(VIEW, 'scholarship', 'scholarship') ||
                        has_permission(VIEW, 'scholarship', 'candidate') ||
                        has_permission(VIEW, 'scholarship', 'donar')
                    ) { ?>
                        <li><a><i class="bi bi-person"></i> <?php echo $this->lang->line('scholarship'); ?><span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'scholarship', 'candidate')) { ?>
                                    <li><a href="<?php echo site_url('scholarship/candidate/index'); ?>"><?php echo $this->lang->line('candidate'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'scholarship', 'donar')) { ?>
                                    <li><a href="<?php echo site_url('scholarship/donar/index'); ?>"><?php echo $this->lang->line('donar'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'scholarship', 'scholarship')) { ?>
                                    <li><a href="<?php echo site_url('scholarship/index'); ?>"><?php echo $this->lang->line('scholarship'); ?></a></li>
                                <?php } ?>

                            </ul>
                        </li>
                    <?php } ?>


                    <?php if (has_permission(VIEW, 'event', 'event')) { ?>
                        <li><a href="<?php echo site_url('event/index'); ?>"><i class="fa fa fa-calendar-check-o"></i> <?php echo $this->lang->line('event'); ?></a></li>
                    <?php } ?>

                    <?php if (has_permission(VIEW, 'payroll', 'grade') || has_permission(VIEW, 'payroll', 'payment')) { ?>
                        <li><a><i class="bi bi-cash-coin"></i> <?php echo $this->lang->line('payroll'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'payroll', 'grade')) { ?>
                                    <li><a href="<?php echo site_url('payroll/grade/index'); ?>"><?php echo $this->lang->line('salary_grade'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'payroll', 'payment')) { ?>
                                    <li><a href="<?php echo site_url('payroll/payment/index'); ?>"> <?php echo $this->lang->line('salary_payment'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'payroll', 'payment')) { ?>
                                    <li><a href="<?php echo site_url('payroll/history/index'); ?>"><?php echo $this->lang->line('salary_history'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if (
                        has_permission(VIEW, 'accounting', 'discount') ||
                        has_permission(VIEW, 'accounting', 'feetype') ||
                        has_permission(VIEW, 'accounting', 'invoice') ||
                        has_permission(VIEW, 'accounting', 'duefeeemail')  ||
                        has_permission(VIEW, 'accounting', 'duefeesms') ||
                        has_permission(VIEW, 'accounting', 'exphead') ||
                        has_permission(VIEW, 'accounting', 'expenditure') ||
                        has_permission(VIEW, 'accounting', 'incomehead') ||
                        has_permission(VIEW, 'accounting', 'income')
                    ) { ?>
                        <li><a><i class="fa fa-calculator"></i> <?php echo $this->lang->line('accounting'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'accounting', 'discount')) { ?>
                                    <li><a href="<?php echo site_url('accounting/discount/index'); ?>"><?php echo $this->lang->line('discount'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'accounting', 'feetype')) { ?>
                                    <li><a href="<?php echo site_url('accounting/feetype/index'); ?>"> <?php echo $this->lang->line('fee_type'); ?></a></li>
                                <?php } ?>

                                <?php if (has_permission(VIEW, 'accounting', 'invoice')) { ?>

                                    <?php if ($this->session->userdata('role_id') == STUDENT || $this->session->userdata('role_id') == GUARDIAN) { ?>
                                        <li><a href="<?php echo site_url('accounting/invoice/due'); ?>"><?php echo $this->lang->line('due_invoice'); ?></a></li>
                                    <?php } else { ?>
                                        <li><a href="<?php echo site_url('accounting/invoice/add'); ?>"><?php echo $this->lang->line('fee_collection'); ?></a></li>
                                        <li><a href="<?php echo site_url('accounting/invoice/index'); ?>"><?php echo $this->lang->line('manage_invoice'); ?></a></li>
                                        <li><a href="<?php echo site_url('accounting/invoice/due'); ?>"><?php echo $this->lang->line('due_invoice'); ?></a></li>
                                    <?php } ?>
                                <?php } ?>

                                <?php if (has_permission(VIEW, 'accounting', 'receipt')) { ?>
                                    <li><a href="<?php echo site_url('accounting/receipt/duereceipt'); ?>"><?php echo $this->lang->line('due_receipt'); ?></a></li>
                                    <li><a href="<?php echo site_url('accounting/receipt/paidreceipt'); ?>"><?php echo $this->lang->line('paid_receipt'); ?></a></li>
                                <?php } ?>

                                <?php if (has_permission(VIEW, 'accounting', 'duefeeemail')) { ?>
                                    <li><a href="<?php echo site_url('accounting/duefeeemail/index'); ?>"><?php echo $this->lang->line('due_fee_email'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'accounting', 'duefeesms')) { ?>
                                    <li><a href="<?php echo site_url('accounting/duefeesms/index'); ?>"><?php echo $this->lang->line('due_fee_sms'); ?></a></li>
                                <?php } ?>

                                <?php if (has_permission(VIEW, 'accounting', 'incomehead')) { ?>
                                    <li><a href="<?php echo site_url('accounting/incomehead/index'); ?>"><?php echo $this->lang->line('income_head'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'accounting', 'income')) { ?>
                                    <li><a href="<?php echo site_url('accounting/income/index'); ?>"><?php echo $this->lang->line('income'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'accounting', 'exphead')) { ?>
                                    <li><a href="<?php echo site_url('accounting/exphead/index'); ?>"><?php echo $this->lang->line('expenditure_head'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'accounting', 'expenditure')) { ?>
                                    <li><a href="<?php echo site_url('accounting/expenditure/index'); ?>"><?php echo $this->lang->line('expenditure'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (has_permission(VIEW, 'report', 'report')) { ?>
                        <li><a><i class="fa fa-bar-chart"></i> <?php echo $this->lang->line('report'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="<?php echo site_url('report/income'); ?>"><?php echo $this->lang->line('income_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/expenditure'); ?>"><?php echo $this->lang->line('expenditure_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/invoice'); ?>"><?php echo $this->lang->line('invoice_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/duefee'); ?>"><?php echo $this->lang->line('due_fee_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/feecollection'); ?>"><?php echo $this->lang->line('fee_collection_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/balance'); ?>"><?php echo $this->lang->line('accounting_balance_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/library'); ?>"><?php echo $this->lang->line('library_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/sattendance'); ?>"><?php echo $this->lang->line('student_attendance_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/syattendance'); ?>"><?php echo $this->lang->line('student_yearly_attendance_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/tattendance'); ?>"><?php echo $this->lang->line('teacher_attendance_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/tyattendance'); ?>"><?php echo $this->lang->line('teacher_yearly_attendance_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/eattendance'); ?>"><?php echo $this->lang->line('employee_attendance_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/eyattendance'); ?>"><?php echo $this->lang->line('employee_yearly_attendance_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/student'); ?>"><?php echo $this->lang->line('student_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/sinvoice'); ?>"><?php echo $this->lang->line('student_invoice_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/sactivity'); ?>"><?php echo $this->lang->line('student_activity_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/payroll'); ?>"><?php echo $this->lang->line('payroll_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/transaction'); ?>"><?php echo $this->lang->line('daily_transaction_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/statement'); ?>"><?php echo $this->lang->line('daily_statement_report'); ?></a></li>
                                <li><a href="<?php echo site_url('report/examresult'); ?>"><?php echo $this->lang->line('exam_result_report'); ?></a></li>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (has_permission(VIEW, 'gallery', 'gallery') || has_permission(VIEW, 'gallery', 'image')) { ?>
                        <li><a><i class="fa fa-image"></i><?php echo $this->lang->line('media_gallery'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'gallery', 'gallery')) { ?>
                                    <li><a href="<?php echo site_url('gallery/index'); ?>"><?php echo $this->lang->line('gallery'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'gallery', 'image')) { ?>
                                    <li><a href="<?php echo site_url('gallery/image/index'); ?>"><?php echo $this->lang->line('gallery_image'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (has_permission(VIEW, 'frontend', 'frontend') || has_permission(VIEW, 'frontend', 'slider')) { ?>
                        <li><a><i class="fa fa-desktop"></i><?php echo $this->lang->line('manage_frontend'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'frontend', 'frontend')) { ?>
                                    <li><a href="<?php echo site_url('frontend/index'); ?>"> <?php echo $this->lang->line('frontend_page'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'frontend', 'slider')) { ?>
                                    <li><a href="<?php echo site_url('frontend/slider/index'); ?>"> <?php echo $this->lang->line('slider'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'frontend', 'about')) { ?>
                                    <li><a href="<?php echo site_url('frontend/about/index'); ?>"><?php echo $this->lang->line('about_school'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if (has_permission(VIEW, 'miscellaneous', 'award') || has_permission(VIEW, 'miscellaneous', 'todo')) { ?>
                        <li><a><i class="fa fa-image"></i><?php echo $this->lang->line('miscellaneous'); ?> <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php if (has_permission(VIEW, 'miscellaneous', 'award')) { ?>
                                    <li><a href="<?php echo site_url('miscellaneous/award/index'); ?>"><?php echo $this->lang->line('manage_award'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'miscellaneous', 'todo')) { ?>
                                    <li><a href="<?php echo site_url('miscellaneous/todo/index'); ?>"><?php echo $this->lang->line('manage_todo'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'miscellaneous', 'faq')) { ?>
                                    <li><a href="<?php echo site_url('miscellaneous/faq/index'); ?>"> <?php echo $this->lang->line('faq'); ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>

                    <?php if ($this->session->userdata('role_id') == SUPER_ADMIN) { ?>
                        <li class="hidden"><a><i class="fa fa-thumbs-o-up"></i><?php echo $this->lang->line('subscription'); ?> (SaaS) <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="<?php echo site_url('subscription/faq/index'); ?>"> <?php echo $this->lang->line('faq'); ?></a></li>
                                <li><a href="<?php echo site_url('subscription/slider/index'); ?>"><?php echo $this->lang->line('slider'); ?></a></li>
                                <li class="hidden"><a href="<?php echo site_url('subscription/setting/index'); ?>"><?php echo $this->lang->line('subscription_setting'); ?></a></li>
                                <li class="hidden"><a href="<?php echo site_url('administrator/setting/index'); ?>"> <?php echo $this->lang->line('general_setting'); ?></a></li>
                                <li class="hidden"><a href="<?php echo site_url('subscription/plan/index'); ?>"><?php echo $this->lang->line('subscription_plan'); ?></a></li>
                                <li class="hidden"><a href="<?php echo site_url('subscription/index'); ?>"><?php echo $this->lang->line('subscription'); ?></a></li>
                            </ul>
                        </li>
                    <?php } ?>


                    <li><a><i class="fa fa-lock"></i><?php echo $this->lang->line('profile'); ?> <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo site_url('profile/index'); ?>"><?php echo $this->lang->line('my_profile'); ?></a></li>
                            <li><a href="<?php echo site_url('profile/password'); ?>"><?php echo $this->lang->line('reset_password'); ?></a></li>
                            <?php if ($this->session->userdata('role_id') == GUARDIAN) { ?>
                                <li><a href="<?php echo site_url('guardian/invoice'); ?>"><?php echo $this->lang->line('invoice'); ?></a></li>
                                <li><a href="<?php echo site_url('guardian/feedback'); ?>"><?php echo $this->lang->line('feedback'); ?></a></li>
                            <?php } ?>
                            <?php if ($this->session->userdata('role_id') == STUDENT) { ?>
                                <li><a href="<?php echo site_url('accounting/invoice/due'); ?>"><?php echo $this->lang->line('invoice'); ?></a></li>
                            <?php } ?>

                            <?php if ($this->session->userdata('role_id') != SUPER_ADMIN) { ?>
                                <?php if (has_permission(VIEW, 'usercomplain', 'usercomplain')) { ?>
                                    <li><a href="<?php echo site_url('usercomplain/index'); ?>"><?php echo $this->lang->line('complain'); ?></a></li>
                                <?php } ?>
                                <?php if (has_permission(VIEW, 'userleave', 'userleave')) { ?>
                                    <li><a href="<?php echo site_url('userleave/index'); ?>"><?php echo $this->lang->line('leave_application'); ?></a></li>
                                <?php } ?>
                            <?php } ?>

                            <li><a href="<?php echo site_url('auth/logout'); ?>"><?php echo $this->lang->line('logout'); ?></a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->
    </div>
</div>