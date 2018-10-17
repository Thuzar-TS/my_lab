<template>
    <div class="animated fadeIn">
        <div class="col-sm-12" v-if="showsetup" id="black-overlay"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="color:#073528;font-weight:bold;">
                        <i class='fa fa-align-justify'></i> Items List <span class='badge badge-primary float-right add-btn' v-on:click='newIte()' style='cursor:pointer;'><i class='fa fa-plus fa-lg'></i></span>
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
                                <tr v-for="(ite,index) in items.data" :key="ite.id">
                                    <td width="50">{{((pagenum-1)*3)+(index+1)}}.</td>
                                    <td>
                                        
                                        <i class="icon-user-female icons" v-if="ite.gender=='2'"  style="font-size:0.9em;color:#f90bab;font-weight:bold;"></i>
                                        <i class="icon-user icons" v-if="ite.gender=='1'" style="font-size:0.9em;color:blue;font-weight:bold;"></i>
                                        <a href="#" title="Profile" style="font-size:0.9em;font-weight:bold;color:green;text-transform: uppercase;">{{ite.item_name}}</a>&nbsp;
                                        <span v-if="ite.itemstatus==1" class="float-right" style="color:orange;font-size:0.9em;">
                                        <i class="fa fa-hospital-o"></i> Initem</span>
                                        <span v-if="ite.itemstatus==2" class="float-right" style="color:orange;font-size:0.9em;">
                                        <i class="fa fa-hospital-o"></i> OPD</span>
                                        <br>
                                        <span class="badge badge-success tbl-btn tbl-btn-success" style="letter-spacing: 1px;font-weight:bold;">
                                        {{ite.item_reference}}
                                        </span>
                                        
                                        <span style="color:red;font-size:0.9em;">[ {{ite.blood_type}} Blood ]</span>
                                        <br>
                                        <span style="font-size:0.9em;font-weight:normal;">
                                            <i class="fa fa-calendar" style="color:blue"></i> {{ite.dob}} ({{ite.age}} years)</span><br>
                                        <span style="font-size:0.9em;font-weight:normal;">{{ite.occuiteion}} ({{ite.marital_status}})</span> 
                                        <br><br>
                                        <a title="edit" v-on:click="editIte(ite.id)">
                                        <span class="badge badge-success tbl-btn tbl-btn-success badge-edit-btn">
                                        Edit
                                        </span></a>
                                        <a title="delete" v-on:click="deleteIte(ite.id, index)">
                                        <span class="badge badge-danger tbl-btn tbl-btn-danger badge-del-btn">
                                        Delete
                                        </span></a>  <span v-if="ite.allergy==1" class="float-right" style="color:red;font-size:0.9em;">
                                        <i class="fa fa-check"></i> Allergy</span> 
                                        <span v-if="ite.allergy==0" class="float-right" style="color:#ccc;font-size:0.9em;">
                                        <i class="fa fa-close"></i> Allergy</span> 
                                    </td>
                                    <td style="font-size:0.9em;">
                                        <i class="fa fa-phone" style="color:blue;"></i> {{ite.phone}}<br>
                                        <i class="fa fa-home" style="color:blue;"></i> {{ite.address}}<br>
                                        <i class="fa fa-map-marker" style="color:blue;"></i> {{ite.city}}<br>
                                        <i class="fa fa-envelope" style="color:blue;"></i> {{ite.email}}<br>
                                        <i class="fa fa-print" style="color:blue;"></i> {{ite.fax}}
                                    </td>
                                    <td style="font-size:0.9em;">
                                        <i class="icon-user icons" style="font-size:0.9em;font-weight:bold;color:blue;"></i> {{ite.father_name}}<br>
                                        <i class="icon-user-female icons" style="font-size:0.9em;font-weight:bold;color:#f90bab;"></i> {{ite.mother_name}}<br><br>
                                        {{ite.nationality}}<br>
                                        {{ite.religion}}
                                    </td>
                                    <td>{{ite.remark}}</td>                                
                                </tr>
                            </tbody>
                        </table>
                        <pagination :data="items" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>            
        </div>
        <div class="col-sm-10" v-if="showsetup" id="whiteoverlay">
            <div class="card">
                <form v-on:submit.prevent="savebtn==true?saveForm():updateIte()">
                <div class="card-header">
                    <i class="fa fa-user-md"></i>Item Setup <i v-on:click="cancelIte()" class="fa fa-close float-right closebtn"></i>
                </div>
               
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="item">Item Name</label>
                                <input placeholder="Item Name" required v-model="ite.description" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <input required v-model="ite.short_description" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="item">Item Code</label>
                                <input placeholder="Code" required v-model="ite.item_code" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <b-form-fieldset label="Item Type">
                                    <b-form-select v-model="ite.item_type_id">
                                        <option value="0">-- Choose --</option>
                                        <option v-for="item in itemtypes" :value="item.id" :key="item.id">{{item.description}}</option>
                                    </b-form-select>
                                </b-form-fieldset>                              
                            </div>

                            <div class="form-group">
                                <b-form-fieldset label="Group">
                                    <b-form-select v-model="ite.group_id">
                                        <option value="0">-- Choose --</option>
                                        <option v-for="item in groups" :value="item.id" :key="item.id">{{item.group_name}}</option>
                                    </b-form-select>
                                </b-form-fieldset>                              
                            </div>

                            <div class="form-group">
                                <!-- <label>Gender</label> -->
                                <div class="row">               
                                <div class="col-sm-6">
                                <div class="radio">
                                <label for="mradio">
                                    <input type="radio" id="mradio" v-model="ite.gender" value="1"> Male
                                </label>
                                </div>  
                            </div>
                            <div class="col-sm-6">
                                <div class="radio">
                                <label for="fradio">
                                    <input type="radio" id="fradio" v-model="ite.gender" value="2"> Female
                                </label>
                                </div>
                                </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group" id="date">
                                        <label for="dob">Date of Birth</label>
                                        <datepicker v-model="ite.dob" :format="customFormatter"></datepicker>
                                        <!-- <input v-model="ite.dob" id="dob" type="text" class="validate form-control">  -->
                                    </div>
                                </div>
                                <div class="col-sm-3" style="padding-left:0px;">
                                    <div class="form-group">
                                        <label for="age">Age</label>
                                        <input v-model="ite.age" id="age" required type="text" class="validate form-control">                          
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <!-- <label>Marital Status</label> -->
                                <div class="row">               
                                <div class="col-sm-6">
                                <div class="radio">
                                <label for="sradio">
                                    <input type="radio" id="sradio" v-model="ite.marital_status" value="Single"> Single
                                </label>
                                </div>  
                            </div>
                            <div class="col-sm-6">
                                <div class="radio">
                                <label for="maradio">
                                    <input type="radio" id="maradio" v-model="ite.marital_status" value="Married"> Married
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
                                                <input type="radio" id="ablood" v-model="ite.blood_type" value="A"> A
                                            </label>
                                        </div>  
                                    </div>
                                    <div class="col-sm-3" style="padding-right:0px;">
                                        <div class="radio">
                                            <label for="bblood">
                                                <input type="radio" id="bblood" v-model="ite.blood_type" value="B"> B
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" style="padding-right:0px;">
                                        <div class="radio">
                                            <label for="abblood">
                                                <input type="radio" id="abblood" v-model="ite.blood_type" value="AB"> AB
                                            </label>
                                        </div>  
                                    </div>
                                    <div class="col-sm-3" style="padding-right:0px;">
                                        <div class="radio">
                                            <label for="oblood">
                                                <input type="radio" id="oblood" v-model="ite.blood_type" value="O"> O
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <b-form-fieldset>
                                    <b-form-checkbox value="1" v-model="ite.allergy" style="cursor:pointer;">Allergy</b-form-checkbox>
                                </b-form-fieldset>                               
                            </div>

                            <div class="form-group">                                
                                <div class="row">               
                                    <div class="col-sm-6">
                                        <div class="radio">
                                            <label for="inpa">
                                                <input type="radio" id="inpa" v-model="ite.itemstatus" value="1"> Initem
                                            </label>
                                        </div>  
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="radio">
                                            <label for="opd">
                                                <input type="radio" id="opd" v-model="ite.itemstatus" value="2"> OPD
                                            </label>
                                        </div>
                                    </div>                                    
                                </div>

                            </div>                            

                            <div class="form-group">
                                <label for="nationality">Nationality</label>
                                <input placeholder="Nationality" v-model="ite.nationality" id="nationality" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="religion">Religion</label>
                                <input v-model="ite.religion" placeholder="Religion" id="religion" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="occuiteion">Occuiteion</label>
                                <input v-model="ite.occuiteion" placeholder="Occuiteion" id="occuiteion" type="text" class="validate form-control">                          
                            </div>
                        </div>
                        
                        <div class="col-sm-3">  
                            <div class="form-group">
                                <label for="fa">Father's Name</label>
                                <input placeholder="Father's Name" id="fa" v-model="ite.father_name" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="mom">Mother's Name</label>
                                <input placeholder="Mother's Name" id="mom" v-model="ite.mother_name" type="text" class="validate form-control">                          
                            </div>                            

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input placeholder="Phone" required id="phone" v-model="ite.phone" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <label for="fax">Fax</label>
                                <input placeholder="Fax" v-model="ite.fax" id="fax" type="text" class="validate form-control">                          
                            </div>                            

                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input placeholder="E-mail" v-model="ite.email" id="email" type="text" class="validate form-control">                          
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea  class="validate form-control" placeholder="Address in details" id="address" v-model="ite.address" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="city">City</label>
                                <input v-model="ite.city" placeholder="City" id="city" type="text" class="validate form-control">                          
                            </div>

                            <div class="form-group">
                                <b-form-fieldset label="State">
                                    <b-form-select v-model="ite.state_id">
                                        <option value="0">-- Choose --</option>
                                        <option v-for="item in states" :value="item.id" :key="item.id">{{item.state_name}}</option>
                                    </b-form-select>
                                </b-form-fieldset>                              
                            </div>

                            <div class="form-group">
                                <label for="remark">Remark</label>
                                <textarea  class="validate form-control" placeholder="Remark in details" id="remark" v-model="ite.remark" rows="3"></textarea>
                            </div>
                        </div>
                    </div>                   
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn-primary btn" v-if="!savebtn" value="Edit">
                    <input type="submit" class="btn-primary btn" v-if="savebtn" value="Save">
                    <label class="btn-primary btn" style="margin-top:8px;" v-on:click="cancelIte()">Cancel</label>
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
      iteId: null,
      ite: {
        item_code: "",
        description: "",
        short_description: "",
        item_type_id: 0,
        group_id: 0,
        expired_date: new Date(),
        lastpurchase_date: new Date(),
        lastsale_date: new Date(),
        category_id: 0,
        brand_id: 0,
        packing: "",
        lastvendor_id: 0,
        inactive: 1,
        ismultilevel: 1,
        usebarcode: 1,
        useexpire: 0,
        sale_account_number: "",
        purchase_account_number: "",
        salereturn_account_number: "",
        purchasereturn_account_number: "",
        img_path: ""
      },
      items: [],
      groups: [],
      categories: [],
      brands: [],
      vendors: [],
      itemtypes: []
    };
  },
  mounted() {
    var app = this;
    axios
      .get("/api/items", {
        headers: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      })
      .then(response => {
        app.items = response.data.items;
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
        .get("/api/items?page=" + page, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          app.pagenum = page;
          app.items = response.data.items;
          // console.log(app.items.length);
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

    newIte() {
      //document.body.classList.toggle("sidebar-minimized");

      // console.log(document.body.classList.length)
      // console.log(document.body.classList.toggle('sidebar-minimized'))
      // document.getElementsByTagName("body").classList.contains("sidebar-minimized");
      if (document.body.classList.length < 6) {
        //console.log("here");
        //document.getElementById("mytoggleclose").click();
        document.body.classList.toggle("sidebar-minimized");
      }

      this.cancelIte();
      this.showsetup = true;

      //   document.getElementById("testingid").classList.toggle("close");
      //   document.getElementsByTagName("body").addClass("sidebar-minimized");
      //  var root = document.documentElement;
      //  root.className += ' sidebar-minimized';
    },

    saveForm() {
      var app = this;
      var newIte = app.ite;
      axios
        .post("/api/items", newIte, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(function(response) {
          alert("New item successfully saved.");
          app.items = response.data.items;
          app.states = response.data.states;
          app.cancelIte();
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

    editIte(id) {
      if (document.body.classList.length < 6) {
        document.body.classList.toggle("sidebar-minimized");
      }
      this.showsetup = true;
      var app = this;
      app.iteId = id;
      app.savebtn = false;
      axios
        .get("/api/items/" + id, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(response => {
          //console.log(response.data);
          app.ite = response.data.items;
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

    updateIte() {
      var app = this;
      var edite = app.ite;
      // console.log("edite" + edite);
      // console.log("iteid" + app.iteId);
      axios
        .post("/api/items/" + app.iteId, edite, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token")
          }
        })
        .then(function(response) {
          alert("item successfully Edited.");
          app.cancelIte();
          app.items = response.data.items;
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

    deleteIte(id, index) {
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios
          .delete("/api/items/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token")
            }
          })
          .then(function(resp) {
            app.items.data.splice(index, 1);
            alert("item successfully deleted.");
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

    cancelIte() {
      var app = this;
      app.savebtn = true;
      app.showsetup = false;

      app.ite.item_code = "";
      app.ite.description = "";
      app.ite.item_type_id = 0;
      app.ite.expired_date = new Date();
      app.ite.lastpurchase_date = new Date();
      app.ite.lastsale_date = new Date();
      app.ite.short_description = "";
      app.ite.group_id = 0;
      app.ite.category_id = 0;
      app.ite.brand_id = 0;
      app.ite.packing = "";
      app.ite.lastvendor_id = 0;
      app.ite.inactive = 0;
      app.ite.ismultilevel = 0;
      app.ite.usebarcode = 0;
      app.ite.useexpire = 0;
      app.ite.state_id = 0;
      app.ite.sale_account_number = "";
      app.ite.purchase_account_number = "";
      app.ite.salereturn_account_number = "";
      app.ite.purchasereturn_account_number = "";
      app.ite.img_path = "";
    }
  }
};
</script>