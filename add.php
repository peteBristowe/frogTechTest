<div id="addUser">
	<input type="text" id="username" placeholder="Username" onkeyup="changed(this.id);" /><br />
	<input type="text" id="fname" placeholder="First Name" onkeyup="changed(this.id);" /><br />
	<input type="text" id="lname" placeholder="Last Name" onkeyup="changed(this.id);" /><br />
	<input type="email" id="email" placeholder="Email" onkeyup="changed(this.id);" /><br />
	<select id="userType" onchange="changed(this.id);">
		<option disabled selected>User Type</option>
		<option disabled>-----</option>
		<option>Admin</option>
		<option>Staff</option>
		<option>Student</option>
		<option>Parent</option>
	</select><br />
	<div class="checkboxLabel">Enabled: <input type="checkbox" value="1" checked id="enabled" /></div><br />
	<button type="button" id="addButton" onclick="addUser();">Add User</button>
</div>