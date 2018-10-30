<template>
    <div class="animated fadeIn">
        <div class="col-sm-12" v-if="showsetup" id="black-overlay"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="color:#073528;font-weight:bold;">
                        <i class='fa fa-align-justify'></i> Vendors List <span class='badge badge-primary float-right add-btn' v-on:click='newVen()' style='cursor:pointer;'><i class='fa fa-plus fa-lg'></i></span>
                    </div>
                    <div class="card-block">                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th style="width:250px">&nbsp;</th>
                                    <th style="width:300px">&nbsp;</th>
                                    <th style="width:200px;">&nbsp;</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ven,index) in vendors.data" :key="ven.id">
                                    <td width="50">{{((pagenum-1)*3)+(index+1)}}.</td>
                                    <td>                                        
                                        <a href="#" title="Profile"><span style="font-size:0.9em;font-weight:bold;color:green;text-transform: uppercase;">{{ven.vendor_name}}</span></a>&nbsp;                                        
                                        <br>
                                        <span class="badge badge-success tbl-btn tbl-btn-success" style="letter-spacing: 1px;font-weight:bold;">
                                        {{ven.vtypename}}
                                        </span>
                                        <span style="color:red;font-size:0.9em;">[ {{ven.state_name}} ]</span>
                                        <br>
                                        <span style="font-size:0.9em;font-weight:normal;">
                                          <a href="#" target="_blank" style="color:blue"><i class="icon-screen-desktop icons"></i> {{ven.website}}</a></span>
                                        <br><br>                                        
                                        <a title="edit" v-on:click="editVen(ven.id)">
                                        <span class="badge badge-success tbl-btn tbl-btn-success badge-edit-btn">
                                        Edit
                                        </span></a>
                                        <a title="delete" v-on:click="deleteVen(ven.id, index)">
                                        <span class="badge badge-danger tbl-btn tbl-btn-danger badge-del-btn">
                                        Delete
                                        </span></a>
                                    </td>
                                    <td style="font-size:0.9em;">
                                        <i class="fa fa-user" style="color:blue;"></i> {{ven.contact_name}}<br>
                                        <i class="fa fa-phone" style="color:blue;"></i> {{ven.phone}}<br>
                                        <i class="fa fa-home" style="color:blue;"></i> {{ven.address}}<br>
                                        <i class="fa fa-map-marker" style="color:blue;"></i> {{ven.city}}<br>
                                        <i class="fa fa-envelope" style="color:blue;"></i> {{ven.email}}<br>
                                    </td>
                                    <td style="font-size:0.9em;">
                                        <span style="color:green;"><i class="fa fa-dollar"></i> {{ven.balance}}</span><br>
                                        <span><i class="fa fa-book" style="color:blue;"></i> {{ven.account_number}}</span><br>
                                        <span><i class="fa fa-book" style="color:blue;"></i> {{ven.purchase_account_number}} <span style="color:orange;">(purchase)</span></span>
                                    </td>
                                    <td>{{ven.remark}}</td>                                
                                </tr>
                            </tbody>
                        </table>
                        <pagination :data="vendors" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>            
        </div>
        <div class="col-sm-10" v-if="showsetup" id="whiteoverlay">
            <div class="card">
                <form v-on:submit.prevent="savebtn==true?saveForm():updateVen()">
                <div class="card-header">
                    <i class="fa fa-user-md"></i>vendor Setup <i v-on:click="cancelVen()" class="fa fa-close float-right closebtn"></i>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="vendor">Vendor's Name</label>
                                <input placeholder="Name" required v-model="ven.vendor_name" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <b-form-fieldset label="Type">
                                    <b-form-select v-model="ven.vendor_type_id">
                                        <option value="0">-- Choose --</option>
                                        <option v-for="item in vendortypes" :value="item.id" :key="item.id">{{item.description}}</option>
                                    </b-form-select>
                                </b-form-fieldset>                              
                            </div>

                            <div class="form-group">
                                <label for="fa">Contact Name</label>
                                <input placeholder="Contact Name" id="fa" v-model="ven.contact_name" type="text" class="validate form-control">                          
                            </div>                         

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input placeholder="Phone" required id="phone" v-model="ven.phone" type="text" class="validate form-control">                          
                            </div> 

                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input placeholder="E-mail" v-model="ven.email" id="email" type="text" class="validate form-control">                          
                            </div>                            
                           
                        </div>
                                              
                        <div class="col-sm-4"> 
                            <div class="form-group">
                                <label for="web">Website</label>
                                <input placeholder="Website" id="web" v-model="ven.website" type="text" class="validate form-control">                          
                            </div>

                             <div class="form-group">
                                <label for="city">City</label>
                                <input v-model="ven.city" placeholder="City" id="city" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <b-form-fieldset label="State">
                                    <b-form-select v-model="ven.state_id">
                                        <option value="0">-- Choose --</option>
                                        <option v-for="item in states" :value="item.id" :key="item.id">{{item.state_name}}</option>
                                    </b-form-select>
                                </b-form-fieldset>                              
                            </div>

                            <div class="form-group">
                                <label for="country">Country</label>
                                <input v-model="ven.country" placeholder="Country" id="country" type="text" class="validate form-control">                          
                            </div>                            

                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea  class="validate form-control" placeholder="Address in details" id="address" v-model="ven.address" rows="3"></textarea>
                                <!-- <input v-model="ven.address" placeholder="Address" id="address" type="text" class="validate form-control">                           -->
                            </div>  
                        </div>

                        <div class="col-sm-4">                           

                            <div class="form-group">
                                <label for="balance">Balance</label>
                                <input placeholder="Balance" required v-model="ven.balance" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="acc">Account Number</label>
                                <input placeholder="Account Number" id="acc" required v-model="ven.account_number" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="puracc">Purchase Account</label>
                                <input placeholder="Purchase Account Number" required id="puracc" v-model="ven.purchase_account_number" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea  class="validate form-control" placeholder="Remark in details" id="remark" v-model="ven.remark" rows="3"></textarea>
                            </div>
                        </div>
                    </div>                   
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn-primary btn" v-if="!savebtn" value="Edit">
                    <input type="submit" class="btn-primary btn" v-if="savebtn" value="Save">
                    <!-- <label class="btn-primary btn" v-if="savebtn" v-on:click="saveForm()"><i class="fa fa-save"></i> Save</label> -->
                    <!-- <label class="btn-primary btn" v-if="!savebtn" v-on:click="updateVen()">Edit</label> -->
                    <label class="btn-primary btn" style="margin-top:8px;" v-on:click="cancelVen()">Cancel</label>
                </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Datepicker from "vuejs-datepicker";
window.moment = require("moment");

export default {
  components: {
    Datepicker
  },
  data: function() {
    return {
      pagenum: 1,
      showsetup: false,
      savebtn: true,
      venId: null,
      ven: {
        vendor_name: "",
        vendor_type_id: 0,
        contact_name: "",
        phone: "",
        address: "",
        dob: new Date(),
        state_id: 0,
        city: "",
        country: "",
        website: "",
        balance: "",
        account_number: "",
        purchase_account_number: "",
        remark: "",
        email: ""
      },
      vendors: [],
      states: [],
      vendortypes: []
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/vendors", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        console.log(response.data);
        app.vendors = response.data.vendors;
        app.states = response.data.states;
        app.vendortypes = response.data.types;
      })
      .catch(error => {
        if (error.response.data.message == "Unauthenticated.") {
          localStorage.removeItem("token");
          store.commit("logoutUser");
          this.$router.push({ name: "login" });
          // this.$route.router.go('/');
        }
      });
  },
  methods: {
    customFormatter(date) {
      //return moment(date).format("DD/MM/YYYY");
      return moment(String(date)).format("MM-DD-YYYY");
    },
    getResults(page) {
      var app = this;

      if (typeof page === "undefined") {
        page = 1;
      }

      axios
        .get("/api/vendors?page=" + page, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.pagenum = page;
          app.vendors = response.data.vendors;
          app.states = response.data.states;
          app.vendortypes = response.data.types;
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

    newVen() {
      if (document.body.classList.length < 6) {
        //console.log("here");
        //document.getElementById("mytoggleclose").click();
        document.body.classList.toggle("sidebar-minimized");
      }

      this.cancelVen();
      this.showsetup = true;
    },

    saveForm() {
      var app = this;
      var newVen = app.ven;
      axios
        .post("/api/vendors", newVen, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(function(response) {
          alert("New vendor successfully saved.");
          app.vendors = response.data.vendors;
          app.states = response.data.states;
          app.vendortypes = response.data.types;
          app.cancelVen();
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

    editVen(id) {
      if (document.body.classList.length < 6) {
        document.body.classList.toggle("sidebar-minimized");
      }
      this.showsetup = true;
      var app = this;
      app.venId = id;
      app.savebtn = false;
      axios
        .get("/api/vendors/" + id, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.ven = response.data.vendors;
          app.states = response.data.states;
          app.vendortypes = response.data.types;
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

    updateVen() {
      var app = this;
      var edven = app.ven;
      // console.log("edven" + edven);
      // console.log("venid" + app.venId);
      axios
        .post("/api/vendors/" + app.venId, edven, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(function(response) {
          alert("vendor successfully Edited.");
          app.cancelVen();
          app.vendors = response.data.vendors;
          app.states = response.data.states;
          app.vendortypes = response.data.types;
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

    deleteVen(id, index) {
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios
          .delete("/api/vendors/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(resp) {
            app.vendors.data.splice(index, 1);
            alert("vendor successfully deleted.");
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

    cancelVen() {
      var app = this;
      app.savebtn = true;
      app.showsetup = false;

      app.ven.vendor_name = "";
      app.ven.vendor_type_id = 0;
      app.ven.dob = new Date();
      app.ven.contact_name = "";
      app.ven.phone = "";
      app.ven.address = "";
      app.ven.city = "";
      app.ven.country = "";
      app.ven.state_id = 0;
      app.ven.balance = "";
      app.ven.website = "";
      app.ven.email = "";
      app.ven.account_number = "";
      app.ven.purchase_account_number = "";
      app.ven.remark = "";
    }
  }
};
</script>