/**
 * 
 */
function getTaskStatusChart(project_id)
    {
        var datastring = {'project_id':project_id};
        $.ajax({
            type: "GET",
            url: "../utility/chartdata.php?type=task_status",
            dataType: 'json',
            data: datastring,
            cache: false,
            success: function(data) {
            	console.log(data.data_pair);
            	var xAxis = [];
        		var yAxis = [];
        
        		for(var i in data.data_pair) {
        			xAxis.push(data.data_pair[i].status);
        			yAxis.push(data.data_pair[i].no_task);
        		}
            	
            	var ctx = document.getElementById("statuschart");
            	var myChart = new Chart(ctx, {
            	    type: 'pie',
            	    data: {
            	        labels: xAxis,
            	        datasets: [{
            	            label: 'Status',
            	            data: yAxis,
            	            backgroundColor: [
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(51, 153, 0, 0.8)',            	                            	                
            	                'rgba(255, 206, 86, 0.8)',  
            	                'rgba(255, 51, 0, 0.8)',          	                
            	            ],
            	            borderColor: [
            	                'rgba(255,255,255,1)',
            	                'rgba(255,255,255,1)',
            	                'rgba(255,255,255,1)',
            	                'rgba(255,255,255,1)'
            	            ],
            	            borderWidth: 1
            	        }]
            	    },
            	    options: {
                        responsive: false
                    },
            	    options: {
            	        scales: {
            	            yAxes: [],
            	            xAxes:[]
            	        }
            	    }
            	});
        
            	
            },
            error: function(){
                  alert('error handling here');
            }
        });
    }

    function getTaskProgressChart(project_id)
    {
        var datastring = {'project_id':project_id};
        $.ajax({
            type: "GET",
            url: "../utility/chartdata.php?type=task_progress",
            dataType: 'json',
            data: datastring,
            cache: false,
            success: function(data) {
            	console.log(data.data_pair);
            	var xAxis = [];
        		var yAxis = [];
        
        		for(var i in data.data_pair) {
        			xAxis.push(data.data_pair[i].task);
        			yAxis.push(data.data_pair[i].percentage);
        		}
            	
            	var ctx = document.getElementById("progresschart");
            	var myChart = new Chart(ctx, {
            	    type: 'bar',
            	    data: {
            	        labels: xAxis,
            	        datasets: [{
            	            label: 'Task',
            	            data: yAxis,
            	            backgroundColor: [
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(51, 153, 0, 0.8)',            	                            	                
            	                'rgba(255, 206, 86, 0.8)',  
            	                'rgba(255, 51, 0, 0.8)',          	                
            	            ],
            	            borderColor: [
            	                'rgba(255,255,255,1)',
            	                'rgba(255,255,255,1)',
            	                'rgba(255,255,255,1)',
            	                'rgba(255,255,255,1)'
            	            ],
            	            borderWidth: 1
            	        }]
            	    },
            	    options: {
                        responsive: false
                    },
            	    options: {
            	        scales: {
            	            yAxes: [{
            	                ticks: {
            	                    beginAtZero:true
            	                }
            	            }]
            	        }
            	    }
            	});
        
            	
            },
            error: function(){
                  alert('error handling here');
            }
        });
    }
    
    
    function getProjectColumnChart()
    {
        $.ajax({
            type: "GET",
            url: "../utility/chartdata.php?type=project_Progress_column",
            dataType: 'json',
            cache: false,
            success: function(data) {
            	console.log(data.data_pair);
            	var xAxis = [];
        		var yAxis = [];
        
        		for(var i in data.data_pair) {
        			xAxis.push(data.data_pair[i].status);
        			yAxis.push(data.data_pair[i].no_projects);
        		}
            	
            	var ctx = document.getElementById("projectcolumnchart");
            	var myChart = new Chart(ctx, {
            	    type: 'bar',
            	    data: {
            	        labels: xAxis,
            	        datasets: [{
            	            label: 'Status',
            	            data: yAxis,
            	            backgroundColor: [
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(51, 153, 0, 0.8)',            	                            	                
            	                'rgba(255, 206, 86, 0.8)',  
            	                'rgba(255, 51, 0, 0.8)',          	                
            	            ],
            	            borderColor: [
            	                'rgba(255,255,255,1)',
            	                'rgba(255,255,255,1)',
            	                'rgba(255,255,255,1)',
            	                'rgba(255,255,255,1)'
            	            ],
            	            borderWidth: 1
            	        }]
            	    },
            	    options: {
                        responsive: false
                    },
            	    options: {
            	        scales: {
            	            yAxes: [{
            	                ticks: {
            	                    beginAtZero:true
            	                }
            	            }]
            	        }
            	    }
            	});
        
            	
            },
            error: function(){
                  alert('error handling here');
            }
        });
    }
    
    function getProjectPieChart()
    {
        $.ajax({
            type: "GET",
            url: "../utility/chartdata.php?type=project_progress_pie",
            dataType: 'json',
            cache: false,
            success: function(data) {
            	console.log(data.data_pair);
            	var xAxis = [];
        		var yAxis = [];
        
        		for(var i in data.data_pair) {
        			xAxis.push(data.data_pair[i].status);
        			yAxis.push(data.data_pair[i].percentage);
        		}
            	
            	var ctx = document.getElementById("projectpiechart");
            	var myChart = new Chart(ctx, {
            	    type: 'pie',
            	    data: {
            	        labels: xAxis,
            	        datasets: [{
            	            label: 'Status',
            	            data: yAxis,
            	            backgroundColor: [
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(51, 153, 0, 0.8)',            	                            	                
            	                'rgba(255, 206, 86, 0.8)',  
            	                'rgba(255, 51, 0, 0.8)',          	                
            	            ],
            	            borderColor: [
            	                'rgba(255,255,255,1)',
            	                'rgba(255,255,255,1)',
            	                'rgba(255,255,255,1)',
            	                'rgba(255,255,255,1)'
            	            ],
            	            borderWidth: 1
            	        }]
            	    },
            	    options: {
                        responsive: false
                    },
            	    options: {
            	        scales: {
            	            yAxes: [],
            	            xAxes:[]
            	        }
            	    }
            	});
        
            	
            },
            error: function(){
                  alert('error handling here');
            }
        });
    }