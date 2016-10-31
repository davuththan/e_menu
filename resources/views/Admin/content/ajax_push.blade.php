<script type="text/javascript">
                $(function(){
                  var menu_parent = $("select[name='menu_type_id']");
                  
                  var isFirstLoad = true;
                  $("#menu_type_id").change(function(){
                    isFirstLoad = true; //to avoid expired message show again
                    //alert(menu_parent.val());
                       $.getdata();
                  });//end origin select

                   $.getdata = function(){
                    //alert('testing');
                    //$('.tab-content a[href="#' + "tab_home" + '"]').tab('show');
                    //refreshDiv();
                        $.ajax({
                                url: "{{url('/admin/contentpage/page_menu')}}",
                                dataType: "json",
                                timeout: 3000,
                                data: {
                                  menu_parent: menu_parent.val(),
                                },
                                error: function(x, t, m) {
                                    if(t==="timeout") {
                                        alert("got timeout");
                                    } else {
                                        alert(t);
                                    }
                                },
                                success: function( data ) {
                                  //console.log(data);
                                  console.log("load data");
                                  if(data.length==0){
                                    $("#loading").hide();
                                    //alert("The page you requested is not found!");
                                    
                                    $("#boxscroll").html("<h1 style='color:#fff;'><center>The page you requested is not found!</center></h1>");
                                    return;
                                  }
                                  text = "";
                                  text += "<option value=''>--Select Page--</option>";
                                  $.each(data,function(menu_parent_id,menu_parent){
                              
                                  text += "<option value='" + menu_parent.id + "'>";
                                  text +=   menu_parent.md_name
                                  text += "</option>";
                                  });
                                  
                                  $("#fmenu_id").html(text); 
                                }
                           });
                      }
                
                });
          </script>

          <script type="text/javascript">
                //window onload
                $(function(){
                  
                  $(window).load(function(){
                   // $.getdata();
                    //$.doTimer();
                    //$.getRateReil();
                    //$.getDiscountRate($customer_type);
                    // if($.cookie("isLeave") != undefined){
                    //   $("#leave_checkbox").prop("checked",true);
                    //   $(".receiver_payment").show();
                    // }
                  });
                  
                });
            </script> 