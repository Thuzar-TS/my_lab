<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-header" style="color:#073528;font-weight:bold;">
                  <i class='fa fa-align-justify'></i> Discharge Types
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
                            <tr v-for="(disch,index) in discharges.data" :key="disch.id">
                                <td>{{((pagenum-1)*5)+(index+1)}}</td>
                                <td>{{disch.description}}</td>
                                <td>
                                    <label v-on:click="editDisch(disch.id, disch.description)">
                                        <i class="fa fa-pencil-square-o fa-lg edit-btn"></i>
                                    </label>                                  
                                </td>
                                <td>
                                    <label v-on:click="deleteDisch(disch.id, index)">
                                        <i class="fa fa-trash fa-lg del-btn"></i>
                                    </label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="discharges" @pagination-change-page="getResults"></pagination>
                </div>
              </div>
            </div>
            <div class="col-md-4">
                <form>
                    <div class="form-group row">
                        <div class="input-field col-sm-12">
                            <label for="unit">New Discharge</label>
                            <input type="text" class="validate form-control" v-model="disch.description">
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <div class="form-group">
                        <label class="btn-primary btn" v-if="savebtn" v-on:click="saveForm()">Save</label>
                        <label class="btn-primary btn" v-if="!savebtn" v-on:click="updateDisch()">Edit</label>
                        <label class="btn-primary btn" v-on:click="cancelDisch()">Cancel</label>
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
      dischId: null,
      disch: {
        description: ""
      },
      discharges: []
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/discharges", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        //console.log(response.data);
        app.discharges = response.data;
      })
      .catch(error => {
        //console.log(error.response);
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
        .get("/api/discharges?page=" + page, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.pagenum = page;
          app.discharges = response.data;
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
      if (app.disch.description != "" && app.disch.description != null) {
        var newdisch = app.disch;
        axios
          .post("/api/discharges", newdisch, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(response) {
            alert("New Discharge successfully saved.");
            app.discharges = response.data;
            app.cancelDisch();
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

    editDisch(id, name) {
      //event.preventDefault();
      var app = this;
      app.disch.description = name;
      app.dischId = id;
      app.savebtn = false;
      //console.log(app.discharges);
      //edit and save button hidden true false
    },

    updateDisch() {
      var app = this;
      if (app.disch.description != "" && app.disch.description != null) {
        var eddisch = app.disch;
        console.log(app);
        axios
          .post("/api/discharges/" + app.dischId, eddisch, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(response) {
            alert("Discharge successfully edited.");
            app.cancelDisch();
            app.discharges = response.data;
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

    deleteDisch(id, index) {
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios
          .delete("/api/discharges/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(resp) {
            app.discharges.data.splice(index, 1);
            //app.getResults(app.pagenum);
            alert("Discharge successfully deleted.");
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

    cancelDisch() {
      var app = this;
      app.savebtn = true;
      app.disch.description = "";
    }
  }
};
</script>