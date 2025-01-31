<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'tw-block tw-w-full tw-ps-3 tw-pe-4 tw-py-2 tw-border-l-4 tw-border-indigo-400 tw-text-start tw-text-base tw-font-medium tw-text-indigo-700 tw-bg-indigo-50 tw-focus:tw-outline-none tw-focus:tw-text-indigo-800 tw-focus:tw-bg-indigo-100 tw-focus:tw-border-indigo-700 tw-transition tw-duration-150 tw-ease-in-out'
        : 'tw-block tw-w-full tw-ps-3 tw-pe-4 tw-py-2 tw-border-l-4 tw-border-transparent tw-text-start tw-text-base tw-font-medium tw-text-gray-600 tw-hover:tw-text-gray-800 tw-hover:tw-bg-gray-50 tw-hover:tw-border-gray-300 tw-focus:tw-outline-none tw-focus:tw-text-gray-800 tw-focus:tw-bg-gray-50 tw-focus:tw-border-gray-300 tw-transition tw-duration-150 tw-ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
