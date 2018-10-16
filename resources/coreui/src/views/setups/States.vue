<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header" style="color:#073528;font-weight:bold;">
                  <i class='fa fa-align-justify'></i> States List
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
                            <tr v-for="(sta,index) in states.data" :key="sta.id">
                                <td>{{((pagenum-1)*5)+(index+1)}}</td>
                                <td>{{sta.state_name}}</td>
                                <td>
                                    <label v-on:click="editSta(sta.id, sta.state_name)">
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
                    <pagination :data="states" @pagination-change-page="getResults"></pagination>
                </div>
              </div>
                <!-- <b-card header="<i class='fa fa-align-justify'></i> States List">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Description</th>
                                <th colspan="2" style="width:30%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(sta,index) in states.data" :key="sta.id">
                                <td>{{((pagenum-1)*5)+(index+1)}}</td>
                                <td>{{sta.state_name}}</td>
                                <td>
                                    <label v-on:click="editSta(sta.id, sta.state_name)">
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
                    <pagination :data="states" @pagination-change-page="getResults"></pagination>
                    
                </b-card> -->
            </div>
            <div class="col-md-4">
                <form>
                    <div class="form-group row">
                        <div class="input-field col-sm-12">
                            <label for="unit">New state</label>
                            <input type="text" class="validate form-control" v-model="sta.state_name">
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <div class="form-group">
                        <label class="btn-primary btn" v-if="savebtn" v-on:click="saveForm()">Save</label>
                        <label class="btn-primary btn" v-if="!savebtn" v-on:click="updateSta()">Edit</label>
                        <label class="btn-primary btn" v-on:click="cancelSta()">Cancel</label>
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
      staId: null,
      sta: {
        state_name: ""
      },
      states: []
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/states", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        app.states = response.data;
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
        .get("/api/states?page=" + page, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.pagenum = page;
          app.states = response.data;
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
      if (app.sta.state_name != "" && app.sta.state_name != null) {
        var newsta = app.sta;
        axios
          .post("/api/states", newsta, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(response) {
            alert("New State successfully saved.");
            app.states = response.data;
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
        alert("Please Fill Compelety.");
      }
    },

    editSta(id, name) {
      //event.preventDefault();
      var app = this;
      app.sta.state_name = name;
      app.staId = id;
      app.savebtn = false;
      //console.log(app.states);
      //edit and save button hidden true false
    },

    updateSta() {
      var app = this;
      if (app.sta.state_name != "" && app.sta.state_name != null) {
        var edsta = app.sta;
        console.log(app);
        axios
          .post("/api/states/" + app.staId, edsta, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(response) {
            alert("State successfully edited.");
            app.cancelSta();
            app.states = response.data;
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

    deleteSta(id, index) {
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios
          .delete("/api/states/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(resp) {
            app.states.data.splice(index, 1);
            app.getResults(app.pagenum);
            alert("State successfully deleted.");
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
      app.sta.state_name = "";
    }
  }
};
</script>