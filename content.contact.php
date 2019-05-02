<section id="contact" class="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h1 style="font-weight: 900; color:#045a73;"><i class="fa fa"></i>GET IN TOUCH &nbsp;<i class="fa fa-phone fa-lg fa-rotate-270"></i></h1>
                
                <p><i>I'd love to be part of your next project, let's have a cup of coffee and talk.</i></p>
            </div>
        </div>
        <hr class="divider">
        <div class="row">
            <div class="col-sm-6">
                
                <div class="row">
                    
                    <div class="col-sm-12 text-center">
                        <i class="fa fa-mobile fa-5x mobile"></i> 
                        <h3 class="text-center"><i>Drop a call or text</i></h3>
                    </div>
                    
                </div>
                
                <div class="row">
                    <div class="col-sm-12 text-center contact-numbers">
                        <h4><b>Primary:</b> <a href="tel:+639550543364">+63 955 054 3364</a></h4>
                        
                        <h4><b>Secondary:</b> <a href="tel:+639353664566">+63 928 571 4521</a></h4>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    
                    <div class="col-sm-12 text-center">
                        <i class="fa fa-at fa-4x mobile"></i> 
                        <h3 class="text-center"><i>Drop direct message</i></h3>
                    </div>
                    
                </div>
                
                <div class="row">
                    <div class="col-sm-12 text-center contact-numbers">
                        <h4><b>Email:</b> <a href="mailto:kingkeiem@gmail.com">kingkeiem@gmail.com</a></h4>
                    </div>
                </div>
                
            </div>
            
            <div class="col-sm-6">
               
                <div class="row">
                    
                    <div class="col-sm-12 text-center">
                        <i class="fa fa-envelope-o fa-4x envelope"></i> 
                        <h3 class="text-center"><i>Drop me a line</i></h3>
                    </div>
                    
                    <div class="row" id="success-message">
                        <div class="col-sm-12">
                            <div  class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <span>Message has been sent! Thank you for getting touch with me.</span>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="error-message">
                        <div class="col-sm-12">
                            <div  class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <span>Message sending failed! Please try-again.</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <form action="<?php //$_SERVER['PHP_SELF']; ?>" method="POST" class="contact-form">
                    
                    <div class="col-sm-6 form-group">
                         <input id="name" type="text" name="name" class="form-control name" placeholder="YOUR NAME" required>
                    </div>
                    
                    <div class="col-sm-6 form-group">
                         <input id="email" type="email" name="email" class="form-control" placeholder="YOUR EMAIL" required>
                    </div>
                    
                    <div class="col-sm-12 form-group">
                        <textarea id="message" name="message" class="form-control message-box" placeholder="MESSAGE"></textarea>
                    </div>
                    
                    <div class="col-sm-12 text-center">
                        <a href="javascript:void(0)" class="btn send-btn">Send Your Message</a>
                    </div>
                    
                </form>
                
            </div>
        </div>
    </div>
</section>