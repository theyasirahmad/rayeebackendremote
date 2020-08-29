var url = path;
fetchUser()

function fetchUser(){
    // Fetch User Table
    $('#userTable').DataTable().destroy();
        var userTable = $('#userTable').DataTable({
          processing: true,
          serverSide: true,
          responsive: false,
          language: { 
              search: "",
              searchPlaceholder: "Search records"
         },
          ajax:{ 
              url: url+'/admin/user'
           },
          columns: [
            { data: 'action', name: 'first_name', orderable: false },
            { data: 'last_name', name: 'last_name' },
            { data: 'gender', name: 'gender' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
        ]
    
    });
    
    }