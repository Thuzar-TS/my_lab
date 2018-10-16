<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header" style="color:#073528;font-weight:bold;">
                  <i class='fa fa-align-justify'></i> Lab Groups List
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
                            <tr v-for="(labg,index) in labgroups.data" :key="labg.id">
                                <td>{{((pagenum-1)*5)+(index+1)}}</td>
                                <td>{{labg.labgroup_name}}</td>
                                <td>
                                    <label v-on:click="editLabg(labg.id, labg.labgroup_name)">
                                        <i class="fa fa-pencil-square-o fa-lg edit-btn"></i>
                                    </label>                                  
                                </td>
                                <td>
                                    <label v-on:click="deleteLabg(labg.id, index)">
                                        <i class="fa fa-trash fa-lg del-btn"></i>
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="labgroups" @pagination-change-page="getResults"></pagination>
                </div>
              </div>
                <!-- <b-card header="<i class='fa fa-align-justify'></i> labgroups List">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Description</th>
                                <th colspan="2" style="width:30%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(labg,index) in labgroups.data" :key="labg.id">
                                <td>{{((pagenum-1)*5)+(index+1)}}</td>
                                <td>{{labg.labgroup_name}}</td>
                                <td>
                                    <label v-on:click="editLabg(labg.id, labg.labgroup_name)">
                                        Edit
                                    </label>                                  
                                </td>
                                <td>
                                    <label v-on:click="deleteLabg(labg.id, index)">
                                        Delete
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="labgroups" @pagination-change-page="getResults"></pagination>
                    
                </b-card> -->
            </div>
            <div class="col-md-4">
                <form>
                    <div class="form-group row">
                        <div class="input-field col-sm-12">
                            <label for="unit">New Lab Group</label>
                            <input type="text" class="validate form-control" v-model="labg.labgroup_name">
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <div class="form-group">
                        <label class="btn-primary btn" v-if="savebtn" v-on:click="saveForm()">Save</label>
                        <label class="btn-primary btn" v-if="!savebtn" v-on:click="updateLabg()">Edit</label>
                        <label class="btn-primary btn" v-on:click="cancelLabg()">Cancel</label>
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
      labgId: null,
      labg: {
        labgroup_name: ""
      },
      labgroups: []
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/labgroups", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        console.log(response.data);
        app.labgroups = response.data;
        
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
  },
  methods: {
    getResults(page) {
      var app = this;

      if (typeof page === "undefined") {
        page = 1;
      }

      axios
        .get("/api/labgroups?page=" + page, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.pagenum = page;
          app.labgroups = response.data;
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
      if (app.labg.labgroup_name != "" && app.labg.labgroup_name != null) {
        var newlabg = app.labg;
        axios
          .post("/api/labgroups", newlabg, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(response) {
            alert("New labgroup successfully saved.");
            app.labgroups = response.data;
            app.cancelLabg();
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

    editLabg(id, name) {
      //event.preventDefault();
      var app = this;
      app.labg.labgroup_name = name;
      app.labgId = id;
      app.savebtn = false;
      //console.log(app.labgroups);
      //edit and save button hidden true false
    },

    updateLabg() {
      var app = this;
      if (app.labg.labgroup_name != "" && app.labg.labgroup_name != null) {
        var edlabg = app.labg;
        console.log(app);
        axios
          .post("/api/labgroups/" + app.labgId, edlabg, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(response) {
            alert("Labgroup successfully edited.");
            app.cancelLabg();
            app.labgroups = response.data;
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

    deleteLabg(id, index) {
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios
          .delete("/api/labgroups/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(resp) {
            app.labgroups.data.splice(index, 1);
            app.getResults(app.pagenum);
            alert("Labgroup successfully deleted.");
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

    cancelLabg() {
      var app = this;
      app.savebtn = true;
      app.labg.labgroup_name = "";
    }
  }
};
</script>