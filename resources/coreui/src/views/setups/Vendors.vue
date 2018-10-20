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
                                        <a href="#" title="Profile" style="font-size:0.9em;font-weight:bold;color:green;text-transform: uppercase;">{{ven.vendor_name}}</a>&nbsp;                                        
                                        <br>
                                        <span class="badge badge-success tbl-btn tbl-btn-success" style="letter-spacing: 1px;font-weight:bold;">
                                        {{ven.vtypename}}
                                        </span>
                                        <span style="color:red;font-size:0.9em;">[ {{ven.state_name}} ]</span>
                                        <br>
                                        <span style="font-size:0.9em;font-weight:normal;">
                                            <i class="fa fa-calendar" style="color:blue"></i> {{ven.dob}} ({{ven.age}} years)</span><br>
                                        <span style="font-size:0.9em;font-weight:normal;">{{ven.occuvenion}} ({{ven.marital_status}})</span> 
                                        <br><br>                                        
                                        <a title="edit" v-on:click="editVen(ven.id)">
                                        <span class="badge badge-success tbl-btn tbl-btn-success badge-edit-btn">
                                        Edit
                                        </span></a>
                                        <a title="delete" v-on:click="deleteVen(ven.id, index)">
                                        <span class="badge badge-danger tbl-btn tbl-btn-danger badge-del-btn">
                                        Delete
                                        </span></a>  <span v-if="ven.allergy==1" class="float-right" style="color:red;font-size:0.9em;">
                                        <i class="fa fa-check"></i> Allergy</span> 
                                        <span v-if="ven.allergy==0" class="float-right" style="color:#ccc;font-size:0.9em;">
                                        <i class="fa fa-close"></i> Allergy</span> 
                                    </td>
                                    <td style="font-size:0.9em;">
                                        <i class="fa fa-phone" style="color:blue;"></i> {{ven.phone}}<br>
                                        <i class="fa fa-home" style="color:blue;"></i> {{ven.address}}<br>
                                        <i class="fa fa-map-marker" style="color:blue;"></i> {{ven.city}}<br>
                                        <i class="fa fa-envelope" style="color:blue;"></i> {{ven.email}}<br>
                                        <i class="fa fa-print" style="color:blue;"></i> {{ven.fax}}
                                    </td>
                                    <td style="font-size:0.9em;">
                                        <i class="icon-user icons" style="font-size:0.9em;font-weight:bold;color:blue;"></i> {{ven.father_name}}<br>
                                        <i class="icon-user-female icons" style="font-size:0.9em;font-weight:bold;color:#f90bab;"></i> {{ven.mother_name}}<br><br>
                                        {{ven.nationality}}<br>
                                        {{ven.religion}}
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
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="vendor">Reference Number</label>
                                <input placeholder="Reference" required v-model="ven.vendor_reference" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="vendor">vendor's Name</label>
                                <input placeholder="Name" required v-model="ven.vendor_name" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="vendor">NRC</label>
                                <input placeholder="NRC" required v-model="ven.nrc" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <!-- <label>Gender</label> -->
                                <div class="row">               
                                <div class="col-sm-6">
                                <div class="radio">
                                <label for="mradio">
                                    <input type="radio" id="mradio" v-model="ven.gender" value="1"> Male
                                </label>
                                </div>  
                            </div>
                            <div class="col-sm-6">
                                <div class="radio">
                                <label for="fradio">
                                    <input type="radio" id="fradio" v-model="ven.gender" value="2"> Female
                                </label>
                                </div>
                                </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group" id="date">
                                        <label for="dob">Date of Birth</label>
                                        <datepicker v-model="ven.dob" :format="customFormatter"></datepicker>
                                        <!-- <input v-model="ven.dob" id="dob" type="text" class="validate form-control">  -->
                                    </div>
                                </div>
                                <div class="col-sm-3" style="padding-left:0px;">
                                    <div class="form-group">
                                        <label for="age">Age</label>
                                        <input v-model="ven.age" id="age" required type="text" class="validate form-control">                          
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <!-- <label>Marital Status</label> -->
                                <div class="row">               
                                <div class="col-sm-6">
                                <div class="radio">
                                <label for="sradio">
                                    <input type="radio" id="sradio" v-model="ven.marital_status" value="Single"> Single
                                </label>
                                </div>  
                            </div>
                            <div class="col-sm-6">
                                <div class="radio">
                                <label for="maradio">
                                    <input type="radio" id="maradio" v-model="ven.marital_status" value="Married"> Married
                                </label>
                                </div>
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Blood Type</label>
                                <div class="row">               
                                    <div class="col-sm-3" style="padding-right:0px;">
                                        <div class="radio">
                                            <label for="ablood">
                                                <input type="radio" id="ablood" v-model="ven.blood_type" value="A"> A
                                            </label>
                                        </div>  
                                    </div>
                                    <div class="col-sm-3" style="padding-right:0px;">
                                        <div class="radio">
                                            <label for="bblood">
                                                <input type="radio" id="bblood" v-model="ven.blood_type" value="B"> B
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="padding-right:0px;">
                                        <div class="radio">
                                            <label for="abblood">
                                                <input type="radio" id="abblood" v-model="ven.blood_type" value="AB"> AB
                                            </label>
                                        </div>  
                                    </div>
                                    <div class="col-sm-3" style="padding-right:0px;">
                                        <div class="radio">
                                            <label for="oblood">
                                                <input type="radio" id="oblood" v-model="ven.blood_type" value="O"> O
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <b-form-fieldset>
                                    <b-form-checkbox value="1" v-model="ven.allergy" style="cursor:pointer;">Allergy</b-form-checkbox>
                                </b-form-fieldset>                               
                            </div>

                            <div class="form-group">                                
                                <!-- <label>vendor Status</label> -->
                                <div class="row">               
                                    <div class="col-sm-6">
                                        <div class="radio">
                                            <label for="inpa">
                                                <input type="radio" id="inpa" v-model="ven.vendorstatus" value="1"> Invendor
                                            </label>
                                        </div>  
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="radio">
                                            <label for="opd">
                                                <input type="radio" id="opd" v-model="ven.vendorstatus" value="2"> OPD
                                            </label>
                                        </div>
                                    </div>                                    
                                </div>

                            </div>                            

                            <div class="form-group">
                                <label for="nationality">Nationality</label>
                                <input placeholder="Nationality" v-model="ven.nationality" id="nationality" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="religion">Religion</label>
                                <input v-model="ven.religion" placeholder="Religion" id="religion" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="occuvenion">Occuvenion</label>
                                <input v-model="ven.occuvenion" placeholder="Occuvenion" id="occuvenion" type="text" class="validate form-control">                          
                            </div>
                        </div>
                        
                        <div class="col-sm-3">  
                            <div class="form-group">
                                <label for="fa">Father's Name</label>
                                <input placeholder="Father's Name" id="fa" v-model="ven.father_name" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="mom">Mother's Name</label>
                                <input placeholder="Mother's Name" id="mom" v-model="ven.mother_name" type="text" class="validate form-control">                          
                            </div>                            

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input placeholder="Phone" required id="phone" v-model="ven.phone" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="fax">Fax</label>
                                <input placeholder="Fax" v-model="ven.fax" id="fax" type="text" class="validate form-control">                          
                            </div>                            

                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input placeholder="E-mail" v-model="ven.email" id="email" type="text" class="validate form-control">                          
                            </div>

                            <!-- <div class="form-group">
                                <label for="country">Country</label>
                                <input v-model="ven.country" placeholder="Country" id="country" type="text" class="validate form-control">                          
                            </div> -->
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea  class="validate form-control" placeholder="Address in details" id="address" v-model="ven.address" rows="3"></textarea>
                                <!-- <input v-model="ven.address" placeholder="Address" id="address" type="text" class="validate form-control">                           -->
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
          // console.log(app.vendors.length);
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
          //console.log(response.data);
          app.ven = response.data.vendors;
          app.states = response.data.states;
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
      app.ven.nrc = "";
      app.ven.gender = 1;
      app.ven.dob = new Date();
      app.ven.vendor_reference = "";
      app.ven.address = "";
      app.ven.age = "";
      app.ven.blood_type = "A";
      app.ven.marital_status = "Single";
      app.ven.city = "";
      app.ven.country = "";
      app.ven.nationality = "";
      app.ven.religion = "";
      app.ven.father_name = "";
      app.ven.state_id = 0;
      app.ven.mother_name = "";
      app.ven.occuvenion = "";
      app.ven.phone = "";
      app.ven.fax = "";
      app.ven.email = "";
      app.ven.allergy = false;
      app.ven.remark = "";
      app.ven.vendorstatus = 1;
    }
  }
};
</script>