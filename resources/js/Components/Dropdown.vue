<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
    align: {
        type: String,
        default: 'right',
    },
    width: {
        type: String,
        default: '48',
    },
    contentClasses: {
        type: String,
        default: 'py-1 bg-white',
    },
});

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const widthClass = computed(() => {
    return {
        48: 'tw-w-48',
    }[props.width.toString()];
});

const alignmentClasses = computed(() => {
    if (props.align === 'left') {
        return 'tw-ltr:tw-origin-top-left tw-rtl:tw-origin-top-right tw-start-0';
    } else if (props.align === 'right') {
        return 'tw-ltr:tw-origin-top-right tw-rtl:tw-origin-top-left tw-end-0';
    } else {
        return 'tw-origin-top';
    }
});

const open = ref(false);
</script>

<template>
    <div class="tw-relative">
        <div @click="open = !open">
            <slot name="trigger" />
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <div v-show="open" class="tw-fixed tw-inset-0 tw-z-40" @click="open = false"></div>

        <Transition
            enter-active-class="tw-transition tw-ease-out tw-duration-200"
            enter-from-class="tw-opacity-0 tw-scale-95"
            enter-to-class="tw-opacity-100 tw-scale-100"
            leave-active-class="tw-transition tw-ease-in tw-duration-75"
            leave-from-class="tw-opacity-100 tw-scale-100"
            leave-to-class="tw-opacity-0 tw-scale-95"
        >
            <div
                v-show="open"
                class="tw-absolute tw-z-50 tw-mt-2 tw-rounded-md tw-shadow-lg"
                :class="['tw-widthClass', 'tw-alignmentClasses']"
                style="display: none"
                @click="open = false"
            >
                <div class="tw-rounded-md tw-ring-1 tw-ring-black tw-ring-opacity-5" :class="contentClasses">
                    <slot name="content" />
                </div>
            </div>
        </Transition>
    </div>
</template>
