<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header" style="color:#073528;font-weight:bold;">
                  <i class='fa fa-align-justify'></i> Users List
                </div>
                <div class="card-block">
                  <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>E-mail</th>
                                <th colspan="2" style="width:20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(sta,index) in users.data" :key="sta.id">
                                <td>{{((pagenum-1)*5)+(index+1)}}</td>
                                <td>{{sta.name}}</td>
                                <td>{{sta.role_name}}</td>
                                <td>{{sta.email}}</td>
                                <td>
                                    <label v-on:click="editSta(sta.id)">
                                        <i class="fa fa-pencil-square-o fa-lg edit-btn"></i>
                                    </label>
                                </td>
                                <td>
                                    <label v-on:click="deleteSta(sta.id, index)">
                                        <i class="fa fa-trash fa-lg del-btn"></i>
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="users" @pagination-change-page="getResults"></pagination> 
                </div>
              </div>
                <!-- <b-card header="<i class='fa fa-align-justify'></i> Users List">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>E-mail</th>
                                <th colspan="2" style="width:30%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(sta,index) in users.data" :key="sta.id">
                                <td>{{((pagenum-1)*5)+(index+1)}}</td>
                                <td>{{sta.name}}</td>
                                <td>{{sta.role_name}}</td>
                                <td>{{sta.email}}</td>
                                <td>
                                    <label v-on:click="editSta(sta.id)">
                                        Edit
                                    </label>
                                    
                                </td>
                                <td>
                                    <label v-on:click="deleteSta(sta.id, index)">
                                        Delete
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="users" @pagination-change-page="getResults"></pagination>                    
                </b-card> -->
            </div>
            <div class="col-md-4">
                <form v-on:submit.prevent="savebtn==true?saveForm():updateSta()">
                        <div class="form-group">
                            <label for="name" class="control-label">Name</label>
                            <input id="name" type="text" class="form-control" v-model="sta.name" required autofocus>
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">E-Mail Address</label>
                            <input id="email" type="email" class="form-control" v-model="sta.email" required>
                        </div>

                        <div class="form-group">
                            <label for="password" class="control-label">Password</label>
                            <input ref="password" type="password" class="form-control" v-model="sta.password" required>
                        </div>                        

                        <div class="form-group">
                            <label for="password-confirm" class="control-label">Confirm Password</label>
                            <input name="password_confirmation" v-validate="'confirmed:password'" type="password" class="form-control" v-model="sta.password_confirmation">                            
                        </div>
                        <div class="alert alert-danger" v-show="errors.any()">
                            <label style="color:red;">Password and Confirm Password should match!</label>
                        </div>

                        <div class="form-group">
                            <b-form-fieldset label="Role">
                                <b-form-select v-model="sta.role_id" :required="true">
                                    <option value="0">-- Choose --</option>
                                    <option v-for="item in roles" :value="item.id" :key="item.id">{{item.role_name}}</option>
                                </b-form-select>
                            </b-form-fieldset>                        
                        </div>

                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">

                        <div class="form-group">
                            <button type="submit" class="btn-primary btn" v-if="savebtn && !passerr">Register</button>
                            <input type="submit" class="btn-primary btn" v-if="!savebtn" value="Edit">
                            <label class="btn-primary btn" style="margin-top:8px;" v-on:click="cancelSta()">Cancel</label>
                        </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

export default {
  
  data: function() {
    return {
      pagenum: 1,
      savebtn: true,
      staId: null,
      sta: {
        name: "",
        password: "",
        email: "",
        password_confirmation: "",
        role_id: 0
      },
      users: [],
      roles: [],
      passerr: false
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/users", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        app.users = response.data.users;
        app.roles = response.data.roles;
      })
      .catch(error => {
        if (error.response.data.message == "Unauthenticated.") {
          localStorage.removeItem("token");
          store.commit("logoutUser");
          this.$router.push({ name: "login" });
          alert("Session Expired. <br>Please Login Again.");
        }
      });
  },
  methods: {
    getResults(page) {
      var app = this;

      if (typeof page === "undefined") {
        page = 1;
      }

      axios
        .get("/api/users?page=" + page, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.pagenum = page;
          //console.log("hello"+response.data);
          app.users = response.data.users;
        })
        .catch(error => {
          if (error.response.data.message == "Unauthenticated.") {
            localStorage.removeItem("token");
            store.commit("logoutUser");
            this.$router.push({ name: "login" });
            alert("Session Expired. <br>Please Login Again.");
          }
        });
    },

    saveForm() {
      var app = this;
      var newsta = app.sta;

      if (
        app.sta.password != "" &&
        app.sta.password_confirmation != "" &&
        app.sta.role_id != 0
      ) {
        this.$validator.validateAll().then(result => {
          if (result) {
            axios
              .post("/api/users", newsta, {
                headers: {
                  Authorization: "Bearer " + localStorage.getItem("token")
                }
              })
              .then(function(response) {
                app.users = response.data.users;
                app.roles = response.data.roles;
                alert("New user successfully saved.");
                app.cancelSta();
              })
              .catch(error => {
                if (error.response.data.message == "Unauthenticated.") {
                  localStorage.removeItem("token");
                  store.commit("logoutUser");
                  this.$router.push({ name: "login" });
                  alert("Session Expired. <br>Please Login Again.");
                }
              });
          } else {
            alert("Please Correct error!");
          }
        });
      } else {
        alert("Please Fill Completely!");
      }
    },

    editSta(id) {
      var app = this;
      app.staId = id;
      app.savebtn = false;
      axios
        .get("/api/users/" + id, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.sta.name = response.data.users.name;
          app.sta.email = response.data.users.email;
          app.sta.role_id = response.data.users.role_id;
          app.roles = response.data.roles;
        })
        .catch(error => {
          if (error.response.data.message == "Unauthenticated.") {
            localStorage.removeItem("token");
            store.commit("logoutUser");
            this.$router.push({ name: "login" });
            alert("Session Expired. <br>Please Login Again.");
          }
        });
    },

    updateSta() {
      var app = this;
      var edsta = app.sta;
      if (
        app.sta.password != "" &&
        app.sta.password_confirmation != "" &&
        app.sta.role_id != 0
      ) {
        this.$validator.validateAll().then(result => {
          if (result) {
            axios
              .post("/api/users/" + app.staId, edsta, {
                headers: {
                  Authorization: "Bearer " + localStorage.getItem("token")
                }
              })
              .then(function(response) {
                alert("User successfully edited.");
                app.cancelSta();
                app.users = response.data.users;
                app.roles = response.data.roles;
              })
              .catch(error => {
                if (error.response.data.message == "Unauthenticated.") {
                  localStorage.removeItem("token");
                  store.commit("logoutUser");
                  this.$router.push({ name: "login" });
                  alert("Session Expired. <br>Please Login Again.");
                }
              });
          } else {
            alert("Please Correct Error!");
          }
        });
      } else {
        alert("Please Fill Completely!");
      }
    },

    deleteSta(id, index) {
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios
          .delete("/api/users/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(resp) {
            app.users.data.splice(index, 1);
            app.getResults(app.pagenum);
            alert("User successfully deleted.");
          })
          .catch(error => {
            if (error.response.data.message == "Unauthenticated.") {
              localStorage.removeItem("token");
              store.commit("logoutUser");
              this.$router.push({ name: "login" });
              alert("Session Expired. <br>Please Login Again.");
            }
          });
      }
    },

    cancelSta() {
      var app = this;
      app.savebtn = true;
      app.sta.name = "";
      app.sta.email = "";
      app.sta.password = "";
      app.sta.password_confirmation = "";
      app.sta.role_id = 0;
    }
  }
};
</script>