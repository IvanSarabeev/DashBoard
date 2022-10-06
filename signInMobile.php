<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link href="css/dashboard.css" rel="stylesheet">
    <link rel="shortcut icon" href="title.png">
    <link rel="stylesheet" href="css/alert.css" />

    <title>Carpet Service</title>
</head>
<body>
<div class="loader-wrapper">
    <span class="loader"><span class="loader-inner"></span></span>
   </div>
   <main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">
						<div class="card">
							<div class="card-body">
								<div class="text-center mb-4 mt-3">
									<h1 class="h2">Добре дошли !</h1>
								</div>
								<div class="m-sm-4">
									<form id="signInMobile">
										<div class="mb-3">
											<label class="form-label">Потребителско име</label>
											<input class="form-control form-control-lg shadow-none errorShow emailCheck" type="text" name="enterUsername" placeholder="Моля въведете потребител" />
										</div>
										<div class="mb-2">
											<label class="form-label">Парола</label>
											<div class="d-flex">
												<input class="form-control form-control-lg border-edit shadow-none errorShow passCheck" id="typeChange" type="password" name="enterPassword" placeholder="Моля въведете парола" />
												<span id="showPass" class="iconSpan errorShow passCheck"><i class="bi bi-eye-fill"></i></span>
												<span id="hidePass" class="iconSpan d-none errorShow passCheck"><i class="bi bi-eye-slash-fill"></i></span>
											</div>
											<small><a href="#">Забравена парола</a></small>
										</div>
										<div class="text-center mt-3">
                                            <button type="submit" class="btn btn-lg btn-primary shadow-none">Влез</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
<script src="dashboard.js"></script>
</body>
</html>