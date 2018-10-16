<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header" style="color:#073528;font-weight:bold;">
                  <i class='fa fa-align-justify'></i> Roles List
                </div>
                <div class="card-block">
                  <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Description</th>
                                <th colspan="2" style="width:20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(ro,index) in roles.data" :key="ro.id">
                                <td>{{((pagenum-1)*5)+(index+1)}}</td>
                                <td>{{ro.role_name}}</td>
                                <td>
                                    <label v-on:click="editRo(ro.id, ro.role_name)">
                                        <i class="fa fa-pencil-square-o fa-lg edit-btn"></i>
                                    </label>
                                    <!-- <router-link :to="{name: 'editro', params: {id: ro.id}}" class="btn btn-xs btn-default">
                                        Edit
                                    </router-link> -->
                                    
                                </td>
                                <td>
                                    <label v-on:click="deleteRo(ro.id, index)">
                                        <i class="fa fa-trash fa-lg del-btn"></i>
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="roles" @pagination-change-page="getResults"></pagination>
                </div>
              </div>
                <!-- <b-card header="<i class='fa fa-align-justify'></i> roles List">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Description</th>
                                <th colspan="2" style="width:30%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(ro,index) in roles.data" :key="ro.id">
                                <td>{{((pagenum-1)*5)+(index+1)}}</td>
                                <td>{{ro.role_name}}</td>
                                <td>
                                    <label v-on:click="editRo(ro.id, ro.role_name)">
                                        Edit
                                    </label>
                                </td>
                                <td>
                                    <label v-on:click="deleteRo(ro.id, index)">
                                        Delete
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="roles" @pagination-change-page="getResults"></pagination>
                 
                </b-card> -->
            </div>
            <div class="col-md-4">
                <!-- <router-link :to="{name: 'CreateUnits'}" class="btn btn-success">Create new company</router-link> -->
                <form>
                    <div class="form-group row">
                        <div class="input-field col-sm-12">
                            <label for="unit">New role</label>
                            <input type="text" class="validate form-control" v-model="ro.role_name">
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <div class="form-group">
                        <label class="btn-primary btn" v-if="savebtn" v-on:click="saveForm()">Save</label>
                        <label class="btn-primary btn" v-if="!savebtn" v-on:click="updateRo()">Edit</label>
                        <label class="btn-primary btn" v-on:click="cancelRo()">Cancel</label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
//import pagination from 'laravel-vue-pagination'
//  Vue.component('pagination', require('laravel-vue-pagination'));
export default {
  //   component: pagination,
  data: function() {
    return {
      pagenum: 1,
      savebtn: true,
      roId: null,
      ro: {
        role_name: ""
      },
      roles: []
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/roles", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        app.roles = response.data;
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
        .get("/api/roles?page=" + page, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.pagenum = page;
          //console.log("hello"+response.data);
          app.roles = response.data;
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
      if (app.ro.role_name != "" && app.ro.role_name != null) {
        var newro = app.ro;
        axios
          .post("/api/roles", newro, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(response) {
            alert("New Role Successfully Saved.");
            app.roles = response.data;
            app.cancelRo();
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
        alert("Please Fill Compelety.");
      }
    },

    editRo(id, name) {
      var app = this;
      app.ro.role_name = name;
      app.roId = id;
      app.savebtn = false;      
    },

    updateRo() {
      var app = this;
      if (app.ro.role_name != "" && app.ro.role_name != null) {
        var edro = app.ro;
        //console.log(app);
        axios
          .post("/api/roles/" + app.roId, edro, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(response) {
            alert("Role Successfully Edited.");
            app.cancelRo();
            app.roles = response.data;
          })
          .catch(error => {
            console.log(error.response);
            if (error.response.data.message == "Unauthenticated.") {
              localStorage.removeItem("token");
              store.commit("logoutUser");
              this.$router.push({ name: "login" });
              alert("Session Expired. <br>Please Login Again.");
            }
          });
      } else {
        alert("Please Fill Compelety.");
      }
    },

    deleteRo(id, index) {
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios
          .delete("/api/roles/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(resp) {
            app.roles.data.splice(index, 1);
            app.getResults(app.pagenum);
            alert("Role Successfully Deleted.");
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

    cancelRo() {
      var app = this;
      app.savebtn = true;
      app.ro.role_name = "";
    }
  }
};
</script>