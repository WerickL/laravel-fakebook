<script steup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
export default {
    name: 'Feed',
    components: {
        Head, AuthenticatedLayout
    },
};
</script>

<template>
    <Head title="Feed" />
    <AuthenticatedLayout>
        <template #header>
            <header  class="tw-bg-white tw-shadow">
                <div class="tw-max-w-7xl tw-mx-auto tw-py-6 tw-px-4 sm:tw-px-6 tw-lg:tw-px-8">
                    <h2 class="tw-font-semibold tw-text-xl tw-ext-gray-800 tw-leading-tight">Feed</h2>
                </div>
            </header>
        </template>
        
        <div class="tw-py-12">
                <div class="tw-max-w-7xl tw-mx-auto sm:tw-px-6 tw-lg:tw-px-8">
                    <div class="tw-bg-white tw-overflow-hidden tw-shadow-sm sm:tw-rounded-lg">
                        <div class="tw-p-6 tw-text-gray-900">
                            teste
                        </div>
                        
                    </div>
                </div>
            </div>
    </AuthenticatedLayout>
    
</template>
