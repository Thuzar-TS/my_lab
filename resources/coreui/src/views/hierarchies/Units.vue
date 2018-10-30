<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header" style="color:#073528;font-weight:bold;">
                    <i class='fa fa-align-justify'></i> Hierarchy
                    </div>
                    <div class="card-block row">
                        <div class="col-md-4">
                            <div class="col-12 hieitems">
                                <label for="">Units</label>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <div class="input-field col-sm-12">
                                                    <input type="text" placeholder="Search Unit Name" class="validate form-control" required v-model="uni.unit_name">
                                                </div>
                                            </div>
                                            <table class="table">
                                                <tr v-for="(uni,index) in units.data" :key="uni.id">
                                                    <td style="display:none;">{{((pagenum-1)*5)+(index+1)}}</td>
                                                    <td>{{uni.unit_name}}</td>
                                                    <td style="width:50px;">
                                                        <div class="nextbox">
                                                            <i class='fa fa-forward'></i>
                                                        </div>
                                                        
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="col-12 hietree">
                                <label for="">Root</label>
                            </div>
                        </div>
                    </div>
                </div>
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
      uniId: null,
      uni: {
        unit_name: ""
      },
      units: [],
      arrhie: []
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/units", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        console.log(response.data);
        app.units = response.data.units;
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
        .get("/api/units?page=" + page, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.pagenum = page;
          app.units = response.data.units;
          // app.punits = response.data.punits;
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
      if (app.uni.unit_name != "" && app.uni.unit_name != null) {
        var newuni = app.uni;
        axios
          .post("/api/units", newuni, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(response) {
            alert("New Unit successfully saved.");
            app.units = response.data.units;
            // app.punits = response.data.punits;
            app.cancelUni();
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

    editUni(id, name) {
      var app = this;
      app.uni.unit_name = name;
      app.uniId = id;
      app.savebtn = false;
    },

    updateUni() {
      var app = this;
      if (app.uni.unit_name != "" && app.uni.unit_name != null) {
        var eduni = app.uni;
        console.log(eduni);
        axios
          .post("/api/units/" + app.uniId, eduni, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(response) {
            alert("Unit successfully edited.");
            app.cancelUni();
            app.units = response.data.units;
            // app.punits = response.data.punits;
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

    deleteUni(id, index) {
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios
          .delete("/api/units/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(resp) {
            app.units.data.splice(index, 1);
            app.getResults(app.pagenum);
            alert("Unit successfully deleted.");
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

    cancelUni() {
      var app = this;
      app.savebtn = true;
      app.uni.unit_name = "";
    }
  }
};
</script>