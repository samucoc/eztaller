<!DOCTYPE html>
<html>
<head>
	<title>Tu Congre v0.1</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">


	<style type="text/css">
		html, body {
		   height: 100%;
		}

		body {
		    overflow-x:hidden;
		}

		.wrapper, .row {
		   height: 100%;
		   margin-left:0;
		   margin-right:0;
		}

		.wrapper:before, .wrapper:after,
		.column:before, .column:after {
		    content: "";
		    display: table;
		}

		.wrapper:after,
		.column:after {
		    clear: both;
		}

		#sidebar {
		    background-color: #eee;
		    padding-left: 0;
		    float: left;
		    min-height: 100%;
		}

		#sidebar .collapse.in {
		    display: inline;
		}

		#sidebar > .nav>li>a {
		    white-space: nowrap;
		    overflow: hidden;
		}

		#main {
		    padding: 15px;
		    left: 0;
		}

		/*
		 * off canvas sidebar
		 * --------------------------------------------------
		 */
		@media screen and (max-width: 768px) {
		    #sidebar {
		        min-width: 44px;
		    }
		    
		    #main {
		        width: 1%;
		        left: 0;
		    }
		    
		    #sidebar .visible-xs {
		       display:inline !important;
		    }
		    
		    .row-offcanvas {
		       position: relative;
		       -webkit-transition: all 0.4s ease-in-out;
		       -moz-transition: all 0.4s ease-in-out;
		       transition: all 0.4s ease-in-out;
		    }
		    
		    .row-offcanvas-left.active {
		       left: 45%;
		    }
		    
		    .row-offcanvas-left.active .sidebar-offcanvas {
		       left: -45%;
		       position: absolute;
		       top: 0;
		       width: 45%;
		    }
		} 
		 
		 
		@media screen and (min-width: 768px) {
		  .row-offcanvas {
		    position: relative;
		    -webkit-transition: all 0.25s ease-out;
		    -moz-transition: all 0.25s ease-out;
		    transition: all 0.25s ease-out;
		  }

		  .row-offcanvas-left.active {
		    left: 3%;
		  }

		  .row-offcanvas-left.active .sidebar-offcanvas {
		    left: -3%;
		    position: absolute;
		    top: 0;
		    width: 3%;
		    text-align: center;
		    min-width:42px;
		  }
		  
		  #main {
		    left: 0;
		  }
		}

	</style>
</head>
<body>
	<div class="wrapper">
	    <div class="row row-offcanvas row-offcanvas-left">
	        <!-- sidebar -->
	        <div class="column col-sm-3 col-xs-1 sidebar-offcanvas" id="sidebar">
	        	<?php include('class/nav.php'); ?>
	        </div>
	        <!-- /sidebar -->

	        <!-- main right col -->
	        <div class="column col-sm-9 col-xs-11" id="main">
	            <p>
	                Tu Congre v<?php echo '0.1'?>
	            </p>
	        </div>
	        <!-- /main -->
	    </div>
	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		/* off-canvas sidebar toggle */
		$('[data-toggle=offcanvas]').click(function() {
		    $('.row-offcanvas').toggleClass('active');
		    $('.collapse').toggleClass('in').toggleClass('hidden-xs').toggleClass('visible-xs');
		});
	</script>

</body>
</html>