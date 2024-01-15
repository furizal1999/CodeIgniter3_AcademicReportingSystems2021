
  <style type="text/css">
    body {
          font-family: sans-serif !important;
        }
        .bg-funky {
          background: #FF1744;
        } 

        .heading {
          color: #fff;
          margin: 30px;
          font-weight: 600;
        }

        img {max-width: 100%;}
            .inbox_msg {
              border: 1px solid #c4c4c4;
              clear: both;
              overflow: hidden;
            }
            .top_spac{ margin: 20px 0 0;}


            .recent_heading {float: left; width:40%;}

            .headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

            .recent_heading h4 {
              color: #05728f;
              font-size: 21px;
              margin: auto;
            }

            .chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
            .chat_ib h5 span{ font-size:13px; float:right;}
            .chat_ib p{ font-size:14px; color:#989898; margin:auto}
            .chat_img {
              float: left;
              width: 11%;
            }
            .chat_ib {
              float: left;
              padding: 0 0 0 15px;
              width: 88%;
            }

            .chat_people{ overflow:hidden; clear:both;}
            .chat_list {
              border-bottom: 1px solid #c4c4c4;
              margin: 0;
              padding: 18px 16px 10px;
            }
            .inbox_chat { height: 550px; overflow-y: scroll;}

            .active_chat{ background:#ebebeb;}

            .incoming_msg_img {
              display: inline-block;
              width: 6%;
            }
            .received_msg {
              display: inline-block;
              padding: 0 0 0 10px;
              vertical-align: top;
              width: 92%;
             }
             .received_withd_msg p {
              background: #e4e8fb none repeat scroll 0 0;
              border-radius: 3px;
              color: #646464;
              font-size: 14px;
              margin: 0;
              padding: 5px 10px 5px 12px;
              width: 100%;
            }
            .time_date {
              color: #747474;
              display: block;
              font-size: 10px;
              margin: 3px 0 0;
            }
            .received_withd_msg { width: 70%;}
            .mesgs {
              float: left;
              padding: 40px;
            }

             .sent_msg p {
              background: #3F51B5 none repeat scroll 0 0;
              border-radius: 3px;
              font-size: 14px;
              margin: 0; color:#fff;
              padding: 5px 10px 5px 12px;
              width:100%;
            }
            .outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
            .sent_msg {
              float: right;
              width: 70%;
              text-align: right;
            }
            .input_msg_write input {
              background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
              border: medium none;
              color: #4c4c4c;
              font-size: 15px;
              min-height: 48px;
              width: 100%;
            }

            .type_msg {border-top: 1px solid #c4c4c4;position: relative;}
            .msg_send_btn {
              background: #05728f none repeat scroll 0 0;
              border: medium none;
              border-radius: 50%;
              color: #fff;
              cursor: pointer;
              font-size: 17px;
              height: 33px;
              position: absolute;
              right: 0;
              top: 11px;
              width: 33px;
            }
            .messaging { background: #fff;}
            .msg_history {
              max-height: 516px;
              overflow-y: auto;
            }

        .credit {
          margin-bottom: 20px;
          margin-top: 20px;
        }

        .credit a {
          color: #fff;
          font-weight: 300;
          letter-spacing: 2px;
          border-bottom: dotted 1px;
        }
  </style>

  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <div class="main-panel">
          <div class="content">
        <div class="panel-header bg-primary-gradient">
          <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
              <div>
                <h1 class="text-white pb-2 fw-bold">FORUM DISKUSI</h1>
                <h5 class="text-white op-7 mb-2">
                  
                  Fakultas Teknik Universitas Islam Riau</h5>
              </div>
              <div class="ml-md-auto py-2 py-md-0">
                
                            </div>
            </div>
          </div>
        </div>

                <!-- selamat datang -->
                <div class="page-inner mt--5">
          <div class="row mt--2">
            <div class="col-md-12">
              <div class="card full-height">
                <div class="card-body">
                <?php echo $this->session->flashdata('messege'); ?>
                

                <div class="messaging">
                  <div class="inbox_msg">

                    <div class="mesgs">
                      <div class="msg_history">
                        <?php
                          if (is_array($data_forum_diskusi) || is_object($data_forum_diskusi))
                          {
                              foreach ($data_forum_diskusi as $value)
                              {
                                if($_SESSION['username']==$value['username_pengirim']){
                        ?>
                                
                                <div class="outgoing_msg">
                                  <div class="sent_msg">

                                    <p><?= $value['isi_pesan'] ?></p>
                                    <span class="time_date"><?= $value['waktu_pesan'] ?></span> </div>
                                </div>
                        <?php
                                }else{
                                  if($value['foto_pengirim']!=""){
                                    $str_foto = base_url("templates/img/dosen/").$value['foto_pengirim'];
                                  }else{
                                    $str_foto = "https://ptetutorials.com/images/user-profile.png";
                                  }
                        ?>
                                <div class="incoming_msg">
                                  <div class="incoming_msg_img"> <img src="<?= $str_foto ?>" alt="sunil"> </div>
                                  <div class="received_msg">
                                    <div class="received_withd_msg">
                                      <h3 class="text-secondary"><?= $value['nama_pengirim'] ?><i class="text-danger">(<?= $value['status_pengirim'] ?>)</i></h3>
                                      <p><?= $value['isi_pesan'] ?></p>
                                      <span class="time_date"><?= $value['waktu_pesan'] ?></span></div>
                                  </div>
                                </div>
                        <?php
                                }
                              }
                          }

                        ?>
                        
                        <div id="pesanBaru"></div>
                      </div>

                    </div>
                  </div>
                
              </div>
              <style type="text/css">
                

                #ta-frame {
                  margin: 0;
                  padding: 10px 10px;
                  width: 90%;
                  height: 20px;
                  border-top: 1px solid gray;
                  margin-bottom: 50px;
                  /*background-color: #eee;*/
                }

                textarea {  
                  overflow: hidden;
                  margin:  0;
                  padding: 10px;
                  border:  0;
                  outline: 0;
                  width: 100%;
                  font-size: 20px;
                  resize: none;
                  background-color: silver;
                }

                .tombolkirim{
                  color: blue;
                }

              </style>
              <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
              <div class="messaging">
                <!-- <form action="" method="GET"> -->
                  <div id="ta-frame">
                    <div class="row">
                      <div class="col-md-10">
                        <textarea rows='1' width="10px" placeholder="Ketik pesan di sini..." id="isi_pesan" class="rounded"></textarea>
                      </div>
                      <div class="col-md-2">
                        <a name="kirim" class="tombolkirim" id="kirimPesan"><i class="fas fa-paper-plane"></i></a>
                      </div>
                    </div>
                  
                  
                </div>
                <!-- </form> -->


              </div>
              <script>

                // Enable pusher logging - don't include this in production
                Pusher.logToConsole = true;

                var pusher = new Pusher('a64f2e32e363a09b9ed7', {
                  cluster: 'ap1'
                });

                var channel = pusher.subscribe('my-channel');
                channel.bind('my-event', function(data) {
                  // alert(JSON.stringify(data));
                  addData(data);
                });

                function addData(data){
                  let length = data.length;
                  // alert(length);
                  var str_data = '';
                  var status_login = '<?= $_SESSION['status_login'] ?>';
                  var username = '<?= $_SESSION['username'] ?>';
                  // alert(username);
                  // alert(data[length-1].username_pengirim);
                  // alert(length);
                  var str_foto= '';
                  // alert(str_foto);
                  if(data[length-1].foto_pengirim!=''){
                    str_foto = '<?= base_url("templates/img/dosen/") ?>' + data[length-1].foto_pengirim;
                  }else{
                    str_foto = "https://ptetutorials.com/images/user-profile.png";
                  }

                  // alert(str_foto);

                  if(status_login==data[length-1].status_pengirim && username==data[length-1].username_pengirim){
                    str_data = '<div class="outgoing_msg"><div class="sent_msg"><p>'+ data[length-1].isi_pesan+ '</p><span class="time_date">'+ data[length-1].waktu_pesan +'</span> </div></div>';
                  }else{
                     str_data = '<div class="incoming_msg"><div class="incoming_msg_img"> <img src="' + str_foto + '" alt="'+str_foto+'"> </div><div class="received_msg"><div class="received_withd_msg"><h3 class="text-secondary">'+ data[length-1].nama_pengirim +'<i class="text-danger">('+ data[length-1].status_pengirim +')</i></h3><p>'+ data[length-1].isi_pesan +'</p><span class="time_date">'+ data[length-1].waktu_pesan +'</span></div></div></div>';
                  }
                  var nilai_lama = document.getElementById('pesanBaru').innerHTML;
                  // alert('Nilai lama : '+nilai_lama);
                  // var node = document.getElementById('test'),

                  // textContent = node.;
                  $('#pesanBaru').html(nilai_lama+str_data);
                }

              </script>
              <script type="text/javascript">
                var div = document.querySelector('#ta-frame');
                var ta =  document.querySelector('textarea');

                ta.addEventListener('keydown', autosize);

                function autosize() {
                  setTimeout(function() {
                    ta. style.cssText = 'height:0px';
                    var height = Math.min(20 * 5, ta.scrollHeight);
                    div.style.cssText = 'height:' + height + 'px';
                    ta. style.cssText = 'height:' + height + 'px';
                  },0);
                }


                $(function(){
                    $( "#kirimPesan" ).click(function(event)
                        {
                            event.preventDefault();
                            var value = {
                              'isi_pesan': $('#isi_pesan').val()
                            }

                            if(value.isi_pesan!=''){
                              document.getElementById("isi_pesan").value = "";
                              $.ajax({
                                url: '<?= base_url(); ?>forum_diskusi/insert_chat',
                                type: 'POST',
                                data: value,
                                dataType: 'JSON',
                                // success : function(data, textStatus, req) {
                                //     alert('success');
                                // },
                                // error: function(req, textStatus, errorThrown) {
                                //     //this is going to happen when you send something different from a 200 OK HTTP
                                //     alert('Ooops, something happened: ' + textStatus + ' ' +errorThrown);
                                // }
                              });
                            }else{
                              alert("Text tidak boleh kosong!");
                            }

                      
                    });
                });
              </script>
              
  



                </div>
              </div>
            </div>
          </div>
        </div>

                    
      </div>
