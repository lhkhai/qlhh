<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
	body {margin: 0;
    height: 100vh;
    display: flex;
    justify-content: center;
    background-color:black;
    overflow: hidden;
    }
    .container {
    	font-size: 10px;
        width: 40em;
        height: 40em;
        /*position: relative;*/
    }
    .sun{
    	position: absolute;
        top: 15em;
        left: 15em;
        width: 10em;
        height: 10em;
        background-color:yellow;
        border-radius: 50%;
        box-shadow: 0 0 3em white;
    }
    .earth, .moon{
    position: absolute;
    border-style:solid;
    border-color: white transparent; 
    border-width: 0.1em 0.1em  0 0;
    border-radius: 50%;
   
    }
    .earth { top: 5em;
    left: 5em;
    width: 30em;
    height: 30em;
    animation: orbit 36.5s linear infinite;
    }
    .moon {
    top: 0;
    right: 0;
    width: 8em;
    height: 8em;
    animation: orbit 2.7s linear infinite;
    }
    .earth::before,
    .moon::before { 
    content: '';
    position: absolute;
    border-radius: 50%;
    }
    .earth::before {
    top: 2.8em;
    right: 2.8em;
    width: 3em;
    height: 3em;
    background-color: aqua;
    }
    .moon::before {
    	top: 0.8em;
        right: 0.2em;
        width: 1.2em;
        height: 1.2em;
        background-color: silver;
    }
    @keyframes orbit {
    to { transform: rotate(360deg);
    }
    }
    
</style>
</head>
<body>
	<div class="container">
    	<div class="sun"></div>
        <div class="earth">
        	<div class="moon"></div>
        </div>
     </div>
     

</body>
</html>
