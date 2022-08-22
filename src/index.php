<!DOCTYPE html>
<html lang="en">
<head>
    <title>Operations</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>
        function JSONtoTable(data) {
            let employees = JSON.parse(data);
            let htmlTable = '<table>' +
                '<tbody>';
            employees.forEach(function (employee) {
                htmlTable += '<tr>' +
                    '<td id="user">' + employee.username + '</td>' +
                    '<td id="name">' + employee.name + '</td>' +
                    '<td id="email">' + employee.email + '</td>' +
                    '<td id="role">' + employee.role + '</td>' +
                    '</tr>'
            } )
            htmlTable += '</tbody>' +
                '</table>'
            return htmlTable;
        }

        function fillTextInputs(index, element) {
            switch(index) {
                case 0:
                    $('#user').val(element.innerHTML);
                    break;
                case 1:
                    $('#name').val(element.innerHTML);
                    break;
                case 2:
                    $('#email').val(element.innerHTML);
                    break;
                case 3:
                    $('#role').val(element.innerHTML);
                    break;
            }
        }

        function refreshList() {
            $.get("getEmployees.php", {
                    role: $('#searchRole').val()
                },
                function (data) {
                    let list = $(".userListByRole");
                    list.html(JSONtoTable(data))
                    list.children("table").first().children("tbody").first().children("tr").on('click', function (event) {
                        $(event.currentTarget).children().each(fillTextInputs);
                    });
                }
            );

        }

        function addEmployee() {
            $.post("addEmployee.php", {
                    user: $('#user').val(),
                    name: $('#name').val(),
                    email: $('#email').val(),
                    role: $('#role').val()
                },
                refreshList
            );
        }

        function updateEmployee() {
            $.post("updateEmployee.php", {
                    user: $('#user').val(),
                    name: $('#name').val(),
                    email: $('#email').val(),
                    role: $('#role').val()
                },
                refreshList
            );
        }

        function deleteEmployee() {
            $.post("deleteEmployee.php", {
                    user: $('#user').val()
                },
                refreshList
            );
        }

        function searchByName() {
            $.get("getEmployees.php", {
                    name: $('#searchName').val()
                },
                function (data, status) {
                    let list = $(".userByName");
                    list.html(JSONtoTable(data));
                    list.children("table").first().children("tbody").first().children("tr").on('click', function (event) {
                        $(event.currentTarget).children().each(fillTextInputs)
                    });
                }
            );
        }

        let currSearch = ""

        $(document).ready(function () {
            $(`#searchRole`).on('input', function () {
                if (currSearch === "")
                    currSearch = "-";
                $("#prevSearch").text("Previous Search: " + currSearch);
                currSearch = $('#searchRole').val()
                refreshList();
            });
            $(`#searchName`).on('keydown', function (event) {
                if (event.keyCode === 13) {
                    searchByName();
                }
            })
            refreshList();
        });


    </script>
</head>
<body>
<form>
    <label for="user">Username:</label><br>
    <input type="text" id="user" name="user"><br>
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name"><br>
    <label for="email">Email:</label><br>
    <input type="text" id="email" name="email"><br>
    <label for="role">Role:</label><br>
    <input type="text" id="role" name="role"><br>
    <input type="button" value="Add" onclick="addEmployee()">
    <input type="button" value="Update" onclick="updateEmployee()">
    <input type="button" value="Delete" onclick="deleteEmployee()"><br>
    <br>
    <label for="searchName">Search by Name:</label><br>
    <input type="text" id="searchName" name="searchName" >
    <input type="button" value="Search" onclick="searchByName()"><br>
    <div class="userByName"></div>
    <br>
    <p id="prevSearch">Previous Search: -</p>
    <label for="searchRole">Search for Role:</label><br>
    <input type="text" id="searchRole" name="searchRole" onchange="refreshList()"><br>
    <div class="userListByRole"></div>
</form>


</body>
</html>
