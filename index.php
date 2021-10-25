<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Kanit:300" rel="stylesheet">
<!------ Include the above in your HEAD tag ---------->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
<style type="text/css">
	body
	{
	background-color: #e9ebee;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	font-family:"Kanit", sans-serif;
	color: black;
	}
</style>
<div class="container"  style="margin-top:120px;margin-bottom:120px;">
	<div class="card bg-light">
		<article class="card-body mx-auto" style="max-width: 400;">
			<h4 class="card-title mt-3 text-center">Create Account</h4>
			<div id='form'>
				<div id='form1'>
					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="fa fa-user"></i>
							</span>
						</div>
						<input name="" class="form-control" id="username" placeholder="ชื่อผู้ใช้งาน" type="text">
					</div>
					<!-- form-group// -->
					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="fa fa-eye"></i>
							</span>
						</div>
						<input name="" class="form-control" placeholder="รหัสผ่าน" id="password"type="Password">
					</div>
					<!-- form-group// -->
					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="fa fa-calendar-alt"></i>
							</span>
						</div>
						<input name="" class="form-control" placeholder="วันเกิด" id="birthday"type="date">
					</div>
					<!-- form-group// -->
					<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="fa fa-credit-card"></i>
							</span>
						</div>
						<input name="" class="form-control" placeholder="เลขบัตรประชาชน" id="cardnumber" type="number">
					</div>
										<div class="form-group input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="fa fa-envelope"></i>
							</span>
						</div>
					<input name="" class="form-control" placeholder="อีเมลล์" id="email" type="email">
					</div>
					<!-- form-group// -->
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block" id="creat"> Create Account  </button>
					</div>
					<!-- form-group// -->
				</div>
			</article>
		</div>
	</div>
	<!-- card.// -->
</div>
<!--container end.//-->
<script>
	function makeid(length) {
   var result           = '';
   var characters       = 'abcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}
	$("#creat").click(()=>{
		var username = $('#username').val();
		var email = $('#email').val();
		let password = $('#password').val();
		let birthday = $('#birthday').val();
		let cardnumber = $('#cardnumber').val();
		var uniqueId = makeid(16)
		
		if(username == '' || password == '' || birthday == '' || cardnumber == '' || email == ''){
			alert('กรอกข้อมูลไม่ครบ')	
			}else if(cardnumber.length !=13){
			alert('เลขบัตรประชาชนผิดพลาด')
			}else{
			$.ajax({
				url:"register.php",
				method:"POST",
				data:{
					action:"step1",
					username:username,
					password:password,
					birthday:birthday,
					cardnumber:cardnumber,
					uniqueId:uniqueId
					
					},success:function (data){
					
					if(typeof data.referenceCode != "undefined"){
					console.log(data.referenceCode)
					$('#form1').remove();
					$('#form').append('<p class="text-center"> Ref Code '+data.referenceCode+'</p><div class="form-group input-group"> <div class="input-group-prepend"> <span class="input-group-text"> <i class="fa fa-key"></i> </span> </div> <input name="" class="form-control" id="otp" placeholder="OTP" type="text"> </div><div class="form-group input-group"> <div class="input-group-prepend"> <span class="input-group-text"> <i class="fa fa-key"></i> </span> </div> <input name="" class="form-control" id="pin" placeholder="Pin" type="text"> </div><div class="form-group"> <button type="submit" class="btn btn-primary btn-block" id="SubmitOtp"> Create Account  </button> </div>');
					
					$("#SubmitOtp").click(()=>{
					var otp = $('#otp').val();
					var pin = $('#pin').val();
					if(pin.length != 6){
						alert('พินไม่ครบ 6 หลัก')
					}else{
						$.ajax({
							url:"register.php",
							method:"POST",
							data:{
								action:"step2",
								otp:otp,
								username:username,
								pin:pin,
								email:email,
								},success:function (data){
								if(typeof  data.deviceToken != "undefined"){
								$('#form').append('<div class="alert alert-primary" role="alert"> deviceToken: '+data.deviceToken+' <br> uniqueId: '+uniqueId+' </div>')
								}else{
								alert('ผิดพลาดกรุณาลองใหม่')
								}
							}
						})
						
					}
						
					})
					}else{
					alert('ผิดพลาดเนื่องจาก พินอาจจหมดอายุหรือบช.ถูกระงับ')
					}
				}
					
				
			})
			
			//$.ajax()
		}
		
		
		})
		</script>
		
				