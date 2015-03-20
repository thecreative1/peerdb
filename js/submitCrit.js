$(document).ready(function(){
                  $('#submitcriteria').on('click', function(){  //works when submit criteria button is clicked
                    
                    //gets posted criteria values
                    var crit1=$('#crit1').val();
                    var crit2=$('#crit2').val();
                    var crit3=$('#crit3').val();
                    var crit4=$('#crit4').val();
                    var crit5=$('#crit5').val();
                    //creates a datastring to pass variables to PHP
                    var dataString='crit1='+crit1+'&crit2='+crit2+'&crit3='+ crit3+'&crit4='+ crit4+'&crit5='+ crit5;
                    
                    if(crit1==''||crit2==''||crit3==''||crit4==''||crit5==''){ //if fields are empty
                      document.getElementById('successDiv').style.display="none";
                      document.getElementById('alertDiv').style.display="";
                      document.getElementById('alert').innerHTML ="Please fill in the required fields!";  
                    }else{ 
                        //Post values with AJAX to PHP
                        $.ajax({
                        type:"POST",
                        url:"../peerdb/submitCrit.php",
                        data: dataString,
                        dataType: 'json',
                        cache: false,
                        success:function(result){
                      
                          if(!result.data){ //error
                            document.getElementById('successDiv').style.display="none";
                            document.getElementById('alertDiv').style.display="";
                            document.getElementById('alert').innerHTML = 'An error occured while submitting!'; 
                          }else{  //successful submission
                            document.getElementById('alertDiv').style.display="none";
                            document.getElementById('successDiv').style.display="";
                            document.getElementById('success').innerHTML = 'Criteria have been submitted!'; 

                            $('form[name="criteria"] td.crit').each(function(index, item) {
                                $(item).text(result.data[index]);
                            });
                          }
                      }
                      });
                        
                        
                    }
                    
                    return false;
                        
                  }); 
                  
                });