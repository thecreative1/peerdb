$(document).ready(function(){
                      $('#allocategroup').on('click', function(){  //works when Submit button is clicked to allocate groups
                        
                        //gets posted values
                        var selection=$("#selectgroup").val();
                        var student=$("#selectstudent").val();
                        
                        //creates a datastring to pass variables to PHP
                        var dataString='selection='+selection+'&student='+student;
                      
                        //Post values with AJAX to PHP
                        $.ajax({
                          type:"POST",
                          url:"../project/allocateGroup.php",
                          data: dataString,
                          cache: false,
                          success:function(data){
                            if(data=="$successmsg"){  //successful (student allocated to group)
                              document.getElementById('alertDiv1').style.display="none";
                              document.getElementById('successDiv1').style.display="";
                              document.getElementById('success1').innerHTML =data;    
                            }else{
                              document.getElementById('alertDiv1').style.display="none"; //failed allocation
                              document.getElementById('successDiv1').style.display="";
                              document.getElementById('success1').innerHTML =data;    
                            }
                          }
                          });

                        return false;
                            
                      }); 
                      
                    });