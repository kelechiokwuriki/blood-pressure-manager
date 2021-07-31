<template>
<div>
    <!-- patients table -->
        <div class="card">
            <div class="card-header">
                    <div class="d-flex mb-3 justify-content-between">
                    <div>
                        <h3>Patients</h3>
                    </div>
                    <div>
                        <button class="btn btn-primary" @click="showAddPatientModal">Add patient</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="data-table_wrapper" class="dataTables_wrapper no-footer">
                    <table id="patientsTable" class="table display table-hover text-center" style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Date added</th>
                                <th scope="col">Date updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(patient, index) in patients" v-bind:key="index" class="order-number-clickable" @click="showPatientDetails(patient.id)">
                                <td>{{patient.name}}</td>
                                <td>{{ moment(patient.created_at).format('MMMM Do YYYY, h:mm:ss a')}}</td>
                                <td>{{ moment(patient.updated_at).format('MMMM Do YYYY, h:mm:ss a')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end patients table-->
            <div class="modal fade p-4" id="addPatientModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-md text-dark" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                            Add patient
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" v-model="patientHolder.name" class="form-control" id="name"
                                    placeholder="Type patient name">
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" v-model="patientHolder.email" class="form-control" id="email"
                                    placeholder="Type patient email">
                                </div>

                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" v-model="patientHolder.phone_number" class="form-control" id="phonenumber"
                                    placeholder="Type patient phone number">
                                </div>

                                <div class="form-group">
                                    <label>Current blood pressure reading (mm Hg)</label>
                                    <input type="number" v-model="patientHolder.observation.reading" class="form-control"
                                    id="bloodpressurereading"
                                    placeholder="88">
                                </div>

                                    <div class="form-group">
                                    <label>Any observation?</label>
                                    <textarea v-model="patientHolder.observation.notes" class="form-control" id="observation">
                                    </textarea>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" :disabled="disableSubmitPatientButton" @click="submitPatient">Submit</button>
                        </div>
                        </div>
                    </div>
            </div>
            <!-- end add patient modal -->
</div>

</template>

<script>
    export default {
        data() {
            return {
                patients: [],
                patientHolder: {
                    name: '',
                    email: '',
                    phone_number: '',
                    observation: {
                        reading: '',
                        notes: ''
                    }

                }
            }
        },
        methods: {
            showAddPatientModal() {
                $("#addPatientModal").modal('show');
            },
            clearAddPatientModal() {
                this.patientHolder.name = '';
                this.patientHolder.email = '';
                this.patientHolder.phone_number = '';
                this.patientHolder.observation.reading = '';
                this.patientHolder.observation.notes = '';
            },
            submitPatient() {
                axios.post('/api/user?role=patient', this.patientHolder).then(response => {
                    if (response.status === 201) {
                        this.patients.unshift(response.data);
                        this.resetDatatable();
                        this.clearAddPatientModal();
                        $("#addPatientModal").modal('hide');

                        return this.$toast.open(`Patient added successfully`);
                    }

                    return this.$toast.open({
                        message: `Error, please try again.`,
                        type: 'error',
                    });
                }).catch(error => {
                    console.log('error', error);
                }).finally(() => {
                })
            },
            resetDatatable() {
                $('#patientsTable').DataTable().destroy();

                setTimeout(function() {
                    $('#patientsTable').DataTable({
                        "order": false,
                        pageLength: 10,
                        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Everything']]
                    });
                });
            },
            moment(date) {
                return moment(date);
            },
            getPatients () {
                axios.get('/api/user/?role=patient').then(response => {
                    this.patients = response.data.data;
                }).catch(error => {
                    console.log('error', error);
                }).finally(() => {
                     $('#patientsTable').DataTable({
                        "ordering": false,
                        pageLength: 10,
                        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Everything']]
                    });
                })
            },
        },
        created() {
            this.getPatients();
        },
        computed: {
            disableSubmitPatientButton() {
                return false;
            }
        }
    }
</script>
