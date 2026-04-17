<div class="relative md:mx-auto bg-white md:rounded-[6px] shadow-sm- overflow-hidden">

                <!-- TOP BAR (OUR NUMBERS TAB + RIBBON) -->
                <div class="border-b border-slate-200 bg-gradient-to-b from-[#f7f7f7] to-[#f1f1f1]">
                    <div class="relative flex items-stretch h-12">
                        <!-- LEFT RED TAB -->
                        <div
                            class="relative flex items-center bg-[#e13b35] text-white
                                pl-6 pr-16 md:rounded-t-[6px] overflow-hidden">
                            <span class="text-[13px] lg:text-sm font-semibold uppercase">
                                 <?php echo e(translate('OUR NUMBERS')); ?>

                            </span>

                            <!-- RIGHT COLORED RIBBON (স্লান্টেড) -->
                            <!-- RIGHT COLORED RIBBON -->
                            <div class="absolute inset-y-0 -right-4 w-16 overflow-hidden">

                          

                                <!-- BLUE STRIP -->
                                <div
                                    class="absolute inset-y-0 right-4 w-6 bg-[#2261aa]  -skew-x-[30deg] origin-bottom">
                                </div>

                                <!-- YELLOW STRIP -->
                                <div
                                    class="absolute inset-y-0 right-0 w-5 bg-[#fff0a1]  -skew-x-[30deg] origin-bottom">
                                </div>

                            </div>

                            <style>
                                .-skew-x-\[30deg\] {
                                    --tw-skew-x: 30deg;
                                    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
                                }
                            </style>

                        </div>

                        <!-- RIGHT SIDE EMPTY GRAY AREA -->
                        <div class="flex-1"></div>
                    </div>
                </div>


                <!-- DESCRIPTION -->
                <div class="px-6 pt-6 pb-2 lg:px-8">
                    <p class="max-w-xl leading-relaxed text-md lg:text-xl text-slate-500 whitespace-pre-line">
                        <?php if(!empty($setting->our_numbers_content)): ?>
                            <?php echo $setting->our_numbers_content; ?>

                        <?php endif; ?>
                    </p>
                </div>

                <!-- NUMBERS -->
                <div class="px-6 pb-8 lg:px-8">
                    <div class="divide-slate-200">

                        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-x-16">

                            <!-- People Helped -->
                            <div class="py-6- md:py-3-">
                                <div class="flex items-center gap-2">
                                    <!-- ✅ round icon -->
                                    <div class="w-12 h-12 rounded-full border border-slate-400 flex items-center justify-center">
                                        <i class="fa-solid fa-users text-slate-600 text-[15px]"></i>
                                    </div>

                                    <div class="flex items-baseline gap-1">
                                        <span class="text-[42px] lg:text-[44px] font-semibold text-slate-800 leading-none">
                                            <?php if(!empty($setting->peaple_helped)): ?>
                                                <?php echo $setting->peaple_helped; ?>

                                            <?php endif; ?>
                                        </span>
                                        <span class="text-lg md:text-xl text-slate-600">
                                            <?php echo e(translate('People Helped')); ?>

                                        </span>
                                    </div>
                                </div>

                                <!-- ✅ line -->
                                <hr class="mt-6 border-t border-slate-500/70">
                            </div>

                            <!-- Volunteers -->
                            <div class="py-6 md:py-3">
                                <div class="flex items-center gap-2">
                                    <!-- ✅ round icon -->
                                    <div class="w-12 h-12 rounded-full border border-slate-400 flex items-center justify-center">
                                        <i class="fa-solid fa-users text-slate-600 text-[15px]"></i>
                                    </div>

                                    <div class="flex items-baseline gap-1">
                                        <span class="text-[42px] lg:text-[44px] font-semibold text-slate-800 leading-none">
                                            <?php if(!empty($setting->volunteers)): ?>
                                                <?php echo $setting->volunteers; ?>

                                            <?php endif; ?>
                                        </span>
                                        <span class="text-lg md:text-xl text-slate-600">
                                            <?php echo e(translate('Volunteers')); ?>

                                        </span>
                                    </div>
                                </div>

                                <!-- ✅ line -->
                                <hr class="mt-6 border-t border-slate-500/70">
                            </div>

                            <!-- Educated children -->
                            <div class="py-6 md:py-8">
                                <div class="flex items-center gap-2">
                                    <!-- ✅ round icon -->
                                    <div class="w-12 h-12 rounded-full border border-slate-400 flex items-center justify-center">
                                        <i class="fa-solid fa-graduation-cap text-slate-600 text-[15px]"></i>
                                    </div>

                                    <div class="flex items-baseline gap-1">
                                        <span class="text-[42px] lg:text-[44px] font-semibold text-[#1F6FEB] leading-none">
                                            <?php if(!empty($setting->educated_children)): ?>
                                                <?php echo $setting->educated_children; ?>

                                            <?php endif; ?>
                                        </span>
                                        <span class="text-lg md:text-xl text-slate-600">
                                            <?php echo e(translate('Educated children')); ?>

                                        </span>
                                    </div>
                                </div>

                                <!-- ✅ line -->
                                <hr class="mt-6 border-t border-slate-500/70">
                            </div>

                            <!-- Served Meal -->
                            <div class="py-6 md:py-8">
                                <div class="flex items-center gap-2">
                                    <!-- ✅ round icon -->
                                    <div class="w-12 h-12 rounded-full border border-slate-400 flex items-center justify-center">
                                        <i class="fa-solid fa-utensils text-slate-600 text-[15px]"></i>
                                    </div>

                                    <div class="flex items-baseline gap-1">
                                        <span class="text-[42px] lg:text-[44px] font-semibold text-slate-800 leading-none">
                                            <?php if(!empty($setting->service_meal)): ?>
                                                <?php echo $setting->service_meal; ?>

                                            <?php endif; ?>
                                        </span>
                                        <span class="text-lg md:text-xl text-slate-600">
                                            <?php echo e(translate('Served Meal')); ?>

                                        </span>
                                    </div>
                                </div>

                                <!-- ✅ line -->
                                <hr class="mt-6 border-t border-slate-500/70">
                            </div>
                        </div>
                    </div>
                </div>
            </div><?php /**PATH C:\Users\MalcaCorp\Desktop\proyecto\public_html\resources\views/frontend/includes/our_number_section.blade.php ENDPATH**/ ?>