<template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

                    <div class="col-span-6 sm:col-span-4">

                        <h1 class="text-lg font-mediumtext-gray-900">
                            Submitted Reports
                        </h1>
                    </div>

                    <div>
                        <div v-if="reports.length == 0" class="mt-10 text-sm text-gray-600">
                            No reports have been submitted for any of your programs.
                        </div>
                        <div v-else-if="reports">

                            <table class="min-w-full divide-y divide-gray-200">

                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report Title</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Submitted</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approved for Verification</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verified Status</th>
                                        <th scope="col" class="relative px-6 py-3">Actions</th>
                                    </tr>
                                </thead>



                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="report in reports" :key="report.id">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ report.title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ report.created_at }}</td>
                                        <td v-if="report.requiresApproval == 1 && report.vendorApproved == 0" class="px-6 py-4 whitespace-nowrap">
                                            <button @click="approveToVerify(report)" class="focus:outline-none text-white text-sm py-1 px-2.5 rounded-md bg-gray-700 hover:bg-gray-900 hover:shadow-lg">Approve</button>
                                        </td>
                                        <td v-if="report.requiresApproval == 1 && report.vendorApproved == 1" class="px-6 py-4 whitespace-nowrap">Approved</td>
                                        <td v-if="report.requiresApproval == 0" class="px-6 py-4 whitespace-nowrap">N/A</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ report.status }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-indigo-600 hover:text-indigo-900">
                                            <button @click="showModal(report)" class="focus:outline-none text-white text-sm py-1 px-2.5 rounded-md bg-gray-700 hover:bg-gray-900 hover:shadow-lg">View Report</button>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>

                        </div>
                    </div>

                    <jet-dialog-modal :show="reportShowModal" @close="reportCloseModal = false">

                        <template #content>
                            <div class="mb-2 font-semibold">Procedure: </div>
                            <ul v-for="step in this.currentReport.procedure" class="list-disc">
                                <li>{{ step }}</li>
                            </ul>
                        </template>

                        <template #footer>
                            <button @click.native="closeModal" class="inline-block ml-2 mt-10 mb-2 w-auto p-1 border-2 rounded border-red-600 bg-red-600 text-white hover:bg-red-700">
                                close
                            </button>
                        </template>
                    </jet-dialog-modal>

                </div>

            </div>
        </div>
    </div>
</template>

<script>import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import JetDialogModal from '@/Jetstream/DialogModal'


    export default {

        components: {
            JetButton,
            JetInput,
            JetLabel,
            JetSectionBorder,
            JetDialogModal,
        },

        data() {
            return {
                reportShowModal: false,
                currentReport: Object,
                approveReportForm: this.$inertia.form({
                    id: '',
                }),
            }
        },

        props: {

            reports: Array,
        },

        created() {
            for (let i = 0; i < this.$props.reports.length; i++) {
                this.$props.reports[i].procedure = JSON.parse(this.$props.reports[i].procedure);
            }     
        },

        methods: {

            closeModal() {

                this.reportShowModal = false;
            },

            showModal(report) {
                this.currentReport = report;
                this.reportShowModal = true;
            },

            approveToVerify(report) {
                this.approveReportForm.id = report.id;
                this.approveReportForm.post('report-approve');

            }

        }

    }</script>
