<template>
<div class="row">
    <div class="col-sm-6">
        <!-- single patient info -->
            <div class="card">
                <div class="card-header">
                        <h5 class="card-title">
                            Patient Information
                        </h5>
                </div>
                <div class="card-body">

                </div>
            </div>
        <!--end single patient info-->

    </div>
    <div class="col-sm-6">
         <!-- single patient info -->
        <div class="card">
            <div class="card-header">
                    <h5 class="card-title">Observations</h5>
            </div>
            <div class="card-body">

            </div>
        </div>
        <!--end single patient info-->

    </div>
        <!-- add observation modal -->
        <div class="modal fade p-4" id="addPatientModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md text-dark" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                        Add observation for patient
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Reading</label>
                                <input type="text" v-model="observation.reading" class="form-control" id="name"
                                placeholder="Type patient name">
                            </div>

                            <div class="form-group">
                                <label>Notes</label>
                                <input type="text" v-model="observation.notes" class="form-control" id="email"
                                placeholder="Type patient email">
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
        <!-- end add observation modal -->
</div>

</template>

<script>
    export default {
        data() {
            return {
                user: {},
                observation: {
                    notes: '',
                    reading: ''
                }
            }
        },
        props: {
            userid: Number
        },
        methods: {
            showAddPatientModal() {
                $("#addPatientModal").modal('show');
            },
            clearAddPatientModal() {
                this.observation.notes = '';
                this.observation.reading = '';
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
                    return this.$toast.open({
                        message: `Error, please try again.`,
                        type: 'error',
                    });
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
            getUser () {
                axios.get(`/api/user/${this.userid}`).then(response => {
                    this.user = response.data;
                }).catch(error => {
                    console.log('error', error);
                }).finally(() => {

                })
            },
        },
        created() {
            this.getUser();
        },
        computed: {
            disableSubmitPatientButton() {
                return false;
            }
        }
    }
</script>
