
{{ content() }}

<div class="container">
	<h2 class="bg-primary">系统信息</h2>
	<table class="table table-striped">
	      <thead>
	        <tr>
	          <th>用户数量</th>
	          <th>在线用户</th>
	          <th>state</th>
	          <th>create time</th>
	          <th>update time</th>
	        </tr>
	      </thead>
	      <tbody>
	       	{% for u in users %}
				<tr>
		          <th scope="row">{{ u.id }}</th>
		          <td>{{ u.productno }}</td>
		          <td>{{ u.state }}</td>
		          <td>{{ u.create_time }}</td>
		          <td>{{ u.update_time }}</td>
		        </tr>
	       	{% endfor %}
	      </tbody>
	</table>
</div>

<div class="container">
	<form class="form-inline">
	  <div class="form-group">
	    <label for="u_productno">productno</label>
	    <input type="text" class="form-control" id="u_productno" placeholder="15521115163">
	  </div>
	  <div class="form-group">
	    <label for="u_state">state</label>
	    <input type="email" class="form-control" id="u_state" placeholder="1">
	  </div>
	  <div class="form-group">
	    <label for="u_imei">imei</label>
	    <input type="email" class="form-control" id="u_imei" placeholder="imei">
	  </div>
	  <div class="form-group">
	    <label for="u_sessionkey">sessionkey</label>
	    <input type="email" class="form-control" id="u_sessionkey" placeholder="sessionkey">
	  </div>
	  <button type="submit" class="btn btn-default">ADD</button>
	</form>
</div>

<div class="container">
	<h2 class="bg-primary">users</h2>
	<table class="table table-striped">
	      <thead>
	        <tr>
	          <th>ID</th>
	          <th>productno</th>
	          <th>state</th>
	          <th>create time</th>
	          <th>update time</th>
	        </tr>
	      </thead>
	      <tbody>
	       	{% for u in users %}
				<tr>
		          <th scope="row">{{ u.id }}</th>
		          <td>{{ u.productno }}</td>
		          <td>{{ u.state }}</td>
		          <td>{{ u.create_time }}</td>
		          <td>{{ u.update_time }}</td>
		        </tr>
	       	{% endfor %}
	      </tbody>
	</table>
</div>

<div class="container">
	<h2 class="bg-primary">clients</h2>
	<table class="table table-striped">
	      <thead>
	        <tr>
	          <th>ID</th>
	          <th>user ID</th>
	          <th>imei</th>
	          <th>access token</th>
	          <th>auth</th>
	          <th>create time</th>
	          <th>update time</th>
	        </tr>
	      </thead>
	      <tbody>
	       	{% for c in clients %}
				<tr>
		          <th scope="row">{{ c.id }}</th>
		          <td>{{ c.user_id }}</td>
		          <td>{{ c.imei }}</td>
		          <td>{{ c.access_token }}</td>
		          <td>{{ c.auth }}</td>
		          <td>{{ c.create_time }}</td>
		          <td>{{ c.update_time }}</td>
		        </tr>
	       	{% endfor %}
	      </tbody>
	</table>
</div>