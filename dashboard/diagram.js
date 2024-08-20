function drawDiagram(data, categories) {
	const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: categories,
      datasets: [{
        label: '# BYN',
        data: data,
        backgroundColor: [ "#69BC59", "#327CDB", "#1A4A8B", 
        	"#E37593", "#FE354B", "#F1C337",
        	"#F7E56D", "#4FAD6D", "#FF6D7A", 
        	"#D35B7E", "#6B8CD1", "#F5D77A", 
        	"#8ED89B", "#FFA3B1", "#195E9B", 
        	"#F9EE9F", "#6EA57D", "#FFA1AD", 
        	"#B1C1E1", "#F8E9B4"],
       hoverOffset: 4,

      }]
    },
    options: {
      radius: '100%',
      cutout: '40%',
      plugins: {
      legend: {
        position: 'left',
      },
      },
	}
  });
}