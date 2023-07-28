$(document).ready(function(){
    /*
        here we recive the json data from the php index, we split the 1st row (wich are the column names) we append it in the html and then 
        the rest of the data will be passed to the databale 
    */

    function proccessData(json){
        $('#myTable').DataTable({            
            data: json
        });
    }
    
    $.getJSON('json-data.json', function(dataIn){
        let trs = '', columns = '';
        columns = dataIn[0];
        console.log(columns);
        columns.forEach(element => {
            trs += `<th>${element}</th>`
        });
        $('#tableHead').html(trs);

        proccessData(dataIn.slice(1));
    });


})