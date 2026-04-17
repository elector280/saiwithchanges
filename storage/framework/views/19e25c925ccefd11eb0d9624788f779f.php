

<?php $__env->startSection('title', 'Edit Mini Campaign'); ?>

<?php $__env->startSection('css'); ?>
    <style>
        .req::after {
            content: " *";
            color: #dc3545;
            font-weight: 700;
        }

        .thumb {
            height: 70px;
            width: 110px;
            object-fit: cover;
            border-radius: 10px;
        }

        .editor-shell .tox-tinymce {
            border-radius: .35rem !important;
        }

        .editor-invalid .tox-tinymce {
            border: 1px solid #dc3545 !important;
        }

        .seo-note-wrap {
            gap: 10px;
        }

        .mini-form-card {
            overflow: hidden;
        }

        .lang-switch-form {
            display: inline-block;
        }

        .mini-help-box {
            background-color: #DFF5F3;
            border-radius: .35rem;
            padding: 10px 12px;
        }

        .mini-help-box i {
            margin-right: 8px;
        }

        .sticky-form-actions {
            position: sticky;
            bottom: 0;
            z-index: 10;
            background: #fff;
            border-top: 1px solid #e9ecef;
        }

        @media (max-width: 767.98px) {
            .sticky-form-actions {
                position: static;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin'); ?>
<?php
    $locale = session('locale', config('app.locale'));
    $languages = \App\Models\Language::where('active', 1)->get();
    $langCode = $languages->firstWhere('language_code', $locale);
    $code = $locale;

    $oldCover = $minicampaign->cover_image ? asset('storage/cover_image/' . $minicampaign->cover_image) : null;
    $oldOg = $minicampaign->og_image ? asset('storage/og_image/' . $minicampaign->og_image) : null;

    $formattedStartDate = old(
        'start_date',
        $minicampaign->start_date ? \Carbon\Carbon::parse($minicampaign->start_date)->format('Y-m-d\TH:i') : ''
    );

    $formattedEndDate = old(
        'end_date',
        $minicampaign->end_date ? \Carbon\Carbon::parse($minicampaign->end_date)->format('Y-m-d\TH:i') : ''
    );
?>

<div class="container-fluid pt-3">
    <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
        <div class="mb-3 mb-md-0">
            <h3 class="mb-2 font-weight-bold main-page-heading">
                Edit Mini Campaign —
                <a href="javascript:void(0)" class="text-primary">
                    <?php echo e(is_array($minicampaign->title) ? ($minicampaign->getDirectValue('title', $code) ?? 'Untitled') : $minicampaign->title); ?>

                </a>
            </h3>

            <div class="small">
                <a href="<?php echo e(url('/dashboard')); ?>" class="text-primary">Dashboard</a>
                <span class="text-muted mx-1">/</span>
                <a href="<?php echo e(route('campaigns.miniCampaignIndex')); ?>" class="text-primary">Mini Campaign</a>
                <span class="text-muted mx-1">/</span>
                <span class="text-muted">Edit</span>
            </div>
        </div>

        <div class="d-flex flex-wrap">
            <a href="<?php echo e(route('campaigns.miniCampaignIndex')); ?>" class="btn btn-sm btn-default mr-2 mb-2 mb-md-0 w3-round-large">
                <i class="far fa-file-alt mr-1"></i> All Mini Campaigns
            </a>
        </div>
    </div>
</div>

<div class="container-fluid pt-2">
    <div class="card card-outline card-light w3-round-large">
        <div class="card-body py-2 px-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="nav nav-pills">
                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <form action="<?php echo e(route('languageUpdateStatus', $language)); ?>" method="POST" class="mr-2 mb-2 lang-switch-form">
                            <?php echo csrf_field(); ?>
                            <button
                                type="submit"
                                class="nav-link font-weight-bold border-0 <?php echo e($locale === $language->language_code ? 'active' : 'bg-light text-muted'); ?>"
                                style="border-radius:10px !important;">
                                <span class="mr-2">
                                    <img src="<?php echo e(asset('storage/country_flag/' . $language->country_flag)); ?>"
                                         alt="<?php echo e($language->title); ?>"
                                         style="height:14px;width:20px;border-radius:1px;">
                                </span>
                                <?php echo e($language->title); ?>

                                <span class="font-weight-normal">(<?php echo e(strtoupper($language->language_code)); ?>)</span>
                            </button>
                        </form>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="small text-muted mt-2 mt-md-0">
                    <i class="far fa-file-alt mr-1"></i>
                    All content fields below are specific to the selected language.
                    Required fields marked <span class="text-danger">*</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-3">

    <?php if(session('success')): ?>
        <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="icon fas fa-check mr-1"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            setTimeout(function () {
                $('#success-alert').alert('close');
            }, 5000);
        </script>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-1"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2 pl-3">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <form id="miniCampaignForm"
          action="<?php echo e(route('campaigns.miniCampaignUpdate', $minicampaign->id)); ?>"
          method="POST"
          enctype="multipart/form-data"
          novalidate>
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <input type="hidden" name="__existing_cover_image" value="<?php echo e($minicampaign->cover_image); ?>">
    <input type="hidden" name="__existing_og_image" value="<?php echo e($minicampaign->og_image); ?>">

        <div class="card w3-round-large mini-form-card"> 
            <div class="card-header seo-card-header">
                <div class="d-flex align-items-start">
                    <div class="seo-icon-box mr-3">
                        <i class="far fa-file-alt w-4"></i>
                    </div>

                    <div class="seo-header-content">
                        <div class="d-flex align-items-center flex-wrap">
                            <h4 class="card-title mb-0 mr-2 label-color">
                                <b class="label-color">Campaign Settings</b>
                            </h4>
                            <span class="badge badge-info px-2 py-1 seo-lang">
                                <?php echo e(strtoupper($code)); ?>

                            </span>
                        </div>
                        <small class="seo-subtitle mb-0 label-color">
                            Status, scheduling, and images — shared across all languages
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Publication Status</label>
                        <select name="status" class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="1" <?php echo e(old('status', (string) $minicampaign->status) == '1' ? 'selected' : ''); ?>>Published</option>
                            <option value="0" <?php echo e(old('status', (string) $minicampaign->status) == '0' ? 'selected' : ''); ?>>Draft</option>
                        </select>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="seo-subtitle mb-0 label-color">
                            Only published mini campaigns are publicly visible.
                        </small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Urgency Tag</label>
                        <input type="text"
                               name="tag_line"
                               value="<?php echo e(old('tag_line', $minicampaign->tag_line)); ?>"
                               class="form-control <?php $__errorArgs = ['tag_line'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Urgent Tag">
                        <?php $__errorArgs = ['tag_line'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="seo-subtitle mb-0 label-color">
                            A short badge label shown on the campaign card to create urgency. Leave blank to hide.
                        </small>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="req font-weight-bold">View Project URL — CTA Link</label>
                        <input type="url"
                               name="view_project_url"
                               value="<?php echo e(old('view_project_url', $minicampaign->view_project_url)); ?>"
                               class="form-control <?php $__errorArgs = ['view_project_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="https://yourdomain.com/projects/slug">
                        <?php $__errorArgs = ['view_project_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="seo-subtitle mb-0 label-color">
                            The destination URL when a visitor clicks the "View Project" call-to-action button.
                        </small>
                    </div>
                </div>

                <div class="seo-divider">
                    <span>SCHEDULING</span>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="font-weight-bold">Start Date & Time</label>
                        <input type="datetime-local"
                               name="start_date"
                               class="form-control <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e($formattedStartDate); ?>">
                        <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="seo-subtitle mb-0 label-color">
                            The date and time this campaign becomes visible.
                        </small>
                    </div>

                    
                </div>

                <div class="seo-divider">
                    <span>Cover Image</span>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Cover Image</label>
                        <input type="file"
                               name="cover_image"
                               class="form-control <?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               accept="image/*">
                        <?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <?php if($oldCover): ?>
                            <div class="mt-2 d-flex align-items-center justify-content-between border rounded p-2">
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-info mr-2"><i class="far fa-image mr-1"></i> Current</span>
                                    <a href="<?php echo e($oldCover); ?>" target="_blank">
                                        <img src="<?php echo e($oldCover); ?>" class="img-thumbnail thumb" alt="Cover">
                                    </a>
                                </div>
                                <a href="<?php echo e($oldCover); ?>" target="_blank" class="btn btn-xs btn-outline-primary">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        <?php endif; ?>

                        <small class="seo-subtitle mb-0 label-color">
                            Hero image displayed at the top of the mini campaign page. Recommended: 1200×630 px.
                        </small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">OG / Social Share Image (Optional)</label>
                        <input type="file"
                               name="og_image"
                               class="form-control <?php $__errorArgs = ['og_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               accept="image/*">
                        <?php $__errorArgs = ['og_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <?php if($oldOg): ?>
                            <div class="mt-2 d-flex align-items-center justify-content-between border rounded p-2">
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-success mr-2"><i class="fas fa-share-alt mr-1"></i> Current</span>
                                    <a href="<?php echo e($oldOg); ?>" target="_blank">
                                        <img src="<?php echo e($oldOg); ?>" class="img-thumbnail thumb" alt="OG">
                                    </a>
                                </div>
                                <a href="<?php echo e($oldOg); ?>" target="_blank" class="btn btn-xs btn-outline-primary">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                        <?php endif; ?>

                        <small class="seo-subtitle mb-0 label-color">
                            Overrides the image shown when this page is shared on Facebook, Twitter, and WhatsApp.
                            If blank, the cover image is used.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card w3-round-large mini-form-card">
            <div class="card-header seo-card-header">
                <div class="d-flex align-items-start">
                    <div class="seo-icon-box mr-3">
                        <i class="far fa-file-alt w-4"></i>
                    </div>

                    <div class="seo-header-content">
                        <div class="d-flex align-items-center flex-wrap">
                            <h4 class="card-title mb-0 mr-2 label-color">
                                <b class="label-color">Content & Copy</b>
                            </h4>
                            <span class="badge badge-info px-2 py-1 seo-lang">
                                <?php echo e(strtoupper($code)); ?>

                            </span>
                        </div>
                        <small class="seo-subtitle mb-0 label-color">
                            Title, slug, donation widget, and campaign body copy
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="font-weight-bold">Campaign Title</label>
                        <input type="text"
                               name="title[<?php echo e($code); ?>]"
                               value="<?php echo e(old('title.' . $code, $minicampaign->getDirectValue('title', $code))); ?>"
                               placeholder="e.g. Donate to Help Venezuela"
                               class="form-control <?php $__errorArgs = ['title.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['title.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">The main headline shown at the top of this mini campaign page.</small>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="font-weight-bold">URL Slug</label>
                        <input type="text"
                               name="slug[<?php echo e($code); ?>]"
                               value="<?php echo e(old('slug.' . $code, $minicampaign->getDirectValue('slug', $code))); ?>"
                               placeholder="e.g. sai-donate-help-venezuela-en"
                               class="form-control <?php $__errorArgs = ['slug.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['slug.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">Used to build the page URL. Lowercase, hyphenated, no spaces.</small>
                    </div>
                </div>

                <div class="seo-divider">
                    <span>SEO Short Description (Above the fold)</span>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="req font-weight-bold">SEO Short Description</label>
                        <div class="editor-shell <?php echo e($errors->has('short_description.' . $code) ? 'editor-invalid' : ''); ?>">
                            <textarea
                                name="short_description[<?php echo e($code); ?>]"
                                rows="6"
                                class="form-control tinymce-editor <?php $__errorArgs = ['short_description.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                data-editor="short_description"
                            ><?php echo e(old('short_description.' . $code, $minicampaign->getDirectValue('short_description', $code))); ?></textarea>
                        </div>
                        <?php $__errorArgs = ['short_description.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <div class="mini-help-box mt-3">
                            <i class="fas fa-file-alt text-info"></i>
                            This text appears at the very top of the page, before the visitor scrolls.
                            Keep it punchy and compelling — ideally 1–3 sentences that explain the cause and invite action.
                        </div>
                    </div>
                </div>

                <div class="seo-divider">
                    <span>Body Copy</span>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="req font-weight-bold">Paragraph One</label>
                        <div class="editor-shell <?php echo e($errors->has('paragraph_one.' . $code) ? 'editor-invalid' : ''); ?>">
                            <textarea
                                name="paragraph_one[<?php echo e($code); ?>]"
                                rows="10"
                                class="form-control tinymce-editor <?php $__errorArgs = ['paragraph_one.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                data-editor="paragraph_one"
                            ><?php echo e(old('paragraph_one.' . $code, $minicampaign->getDirectValue('paragraph_one', $code))); ?></textarea>
                        </div>
                        <?php $__errorArgs = ['paragraph_one.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="req font-weight-bold">Paragraph Two</label>
                        <div class="editor-shell <?php echo e($errors->has('paragraph_two.' . $code) ? 'editor-invalid' : ''); ?>">
                            <textarea
                                name="paragraph_two[<?php echo e($code); ?>]"
                                rows="10"
                                class="form-control tinymce-editor <?php $__errorArgs = ['paragraph_two.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                data-editor="paragraph_two"
                            ><?php echo e(old('paragraph_two.' . $code, $minicampaign->getDirectValue('paragraph_two', $code))); ?></textarea>
                        </div>
                        <?php $__errorArgs = ['paragraph_two.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="seo-divider">
                    <span>Donation Widget</span>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="font-weight-bold">Donation Box Embed</label>
                        <textarea
                            name="donation_box[<?php echo e($code); ?>]"
                            rows="5"
                            class="form-control <?php $__errorArgs = ['donation_box.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder='<iframe src="..."></iframe>'
                        ><?php echo e(old('donation_box.' . $code, $minicampaign->getDirectValue('donation_box', $code))); ?></textarea>
                        <?php $__errorArgs = ['donation_box.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted d-block mt-2">
                            Paste the mini campaign donation box iframe embed code. Example:
                            <code>&lt;iframe src="..."&gt;&lt;/iframe&gt;</code>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card w3-round-large mini-form-card">
            <div class="card-header seo-card-header">
                <div class="d-flex align-items-start">
                    <div class="seo-icon-box mr-3">
                        <i class="far fa-file-alt w-4"></i>
                    </div>

                    <div class="seo-header-content">
                        <div class="d-flex align-items-center flex-wrap">
                            <h4 class="card-title mb-0 mr-2 label-color">
                                <b class="label-color">SEO & Social Sharing</b>
                            </h4>
                            <span class="badge badge-info px-2 py-1 seo-lang">
                                <?php echo e(strtoupper($code)); ?>

                            </span>
                        </div>
                        <small class="seo-subtitle mb-0 label-color">
                            Meta tags, Open Graph, keywords, and canonical URL
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                            <span>Meta Title</span>
                            <span class="badge badge-light border ml-2 px-2 py-1" style="background-color: #DCFCE7;">
                                meta name="title"
                            </span>
                        </label>
                        <input type="text"
                               name="meta_title[<?php echo e($code); ?>]"
                               value="<?php echo e(old('meta_title.' . $code, $minicampaign->getDirectValue('meta_title', $code))); ?>"
                               class="form-control <?php $__errorArgs = ['meta_title.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="meta_title_<?php echo e($code); ?>">
                        <?php $__errorArgs = ['meta_title.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="d-flex justify-content-between align-items-center mt-2 seo-note-wrap">
                            <small class="seo-help-text">
                                Recommended: 50–60 characters • Appears as the clickable headline in Google.
                            </small>
                            <small class="seo-count-text font-weight-bold mb-0">
                                <span id="meta_title_count_<?php echo e($code); ?>">0</span> / 60
                            </small>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                            <span>Meta Keywords</span>
                            <span class="badge badge-light border ml-2 px-2 py-1" style="background-color: #FEF3C7;">
                                meta name="keywords"
                            </span>
                        </label>
                        <input type="text"
                               name="meta_keywords[<?php echo e($code); ?>]"
                               value="<?php echo e(old('meta_keywords.' . $code, $minicampaign->getDirectValue('meta_keywords', $code))); ?>"
                               class="form-control <?php $__errorArgs = ['meta_keywords.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="keyword1, keyword2">
                        <?php $__errorArgs = ['meta_keywords.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">Comma-separated keywords. Not a major ranking factor but useful for internal tagging.</small>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                            <span>Meta Description</span>
                            <span class="badge badge-light border ml-2 px-2 py-1" style="background-color: #DBEAFE;">
                                meta name="description"
                            </span>
                        </label>
                        <textarea
                            name="meta_description[<?php echo e($code); ?>]"
                            rows="4"
                            class="form-control <?php $__errorArgs = ['meta_description.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="meta_description_<?php echo e($code); ?>"
                        ><?php echo e(old('meta_description.' . $code, $minicampaign->getDirectValue('meta_description', $code))); ?></textarea>
                        <?php $__errorArgs = ['meta_description.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <div class="mini-help-box mt-3">
                            <i class="fas fa-file-alt text-info"></i>
                            <strong>What it is:</strong>
                            The short paragraph shown beneath the SEO title in Google results.
                            It does not directly affect ranking but strongly influences click-through rate.
                            Aim for <strong>120–160 characters</strong>.
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <small class="text-muted">
                                Recommended: 120–160 characters · Shown as the grey snippet text in Google.
                            </small>
                            <small class="font-weight-bold mb-0">
                                <span id="meta_description_count_<?php echo e($code); ?>">0</span> / 160
                            </small>
                        </div>
                    </div>
                </div>

                <div class="seo-divider">
                    <span>Open Graph — Social Sharing</span>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                            <span>OG Title</span>
                            <span class="badge badge-light border ml-2 px-2 py-1" style="background-color: #DCFCE7;">
                                meta property="og:title"
                            </span>
                        </label>
                        <input type="text"
                               name="og_title[<?php echo e($code); ?>]"
                               value="<?php echo e(old('og_title.' . $code, $minicampaign->getDirectValue('og_title', $code))); ?>"
                               class="form-control <?php $__errorArgs = ['og_title.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Title shown when shared on social media...">
                        <?php $__errorArgs = ['og_title.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">
                            Overrides the page title when shared on Facebook, Twitter, WhatsApp. If blank, falls back to Meta Title.
                        </small>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                            <span>Canonical URL</span>
                            <span class="badge badge-light border ml-2 px-2 py-1" style="background-color: #EDE9FE;">
                                rel="canonical"
                            </span>
                        </label>
                        <input type="url"
                               name="canonical_url[<?php echo e($code); ?>]"
                               value="<?php echo e(old('canonical_url.' . $code, $minicampaign->getDirectValue('canonical_url', $code))); ?>"
                               class="form-control <?php $__errorArgs = ['canonical_url.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="https://sai.ngo/mini/campaign-slug">
                        <?php $__errorArgs = ['canonical_url.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">
                            Optional canonical URL override.
                        </small>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="label-color font-weight-bold d-flex align-items-center mb-2">
                            <span>OG Description</span>
                            <span class="badge badge-light border ml-2 px-2 py-1" style="background-color: #DCFCE7;">
                                og:description
                            </span>
                        </label>
                        <textarea
                            name="og_description[<?php echo e($code); ?>]"
                            rows="4"
                            class="form-control <?php $__errorArgs = ['og_description.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Description shown when this page is shared on social media..."
                        ><?php echo e(old('og_description.' . $code, $minicampaign->getDirectValue('og_description', $code))); ?></textarea>
                        <?php $__errorArgs = ['og_description.' . $code];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <div class="mini-help-box mt-3">
                            <i class="fas fa-file-alt text-info"></i>
                            This text appears in social media share previews on Facebook, Twitter, LinkedIn, and WhatsApp.
                            Aim for 100–200 characters — something compelling that makes people want to click.
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end flex-wrap sticky-form-actions">
                <a href="<?php echo e(route('campaigns.miniCampaignIndex')); ?>"
                   class="btn mr-2 mb-2"
                   style="background-color: #afb3ba;">
                    <i class="fas fa-times"></i> Discard Changes
                </a>

                <button type="button"
                        id="previewBtn"
                        class="btn mr-2 mb-2"
                        style="background-color: #afb3ba;">
                    <i class="fas fa-eye"></i> Preview
                </button>

                <button type="submit"
                        id="realSubmitBtn"
                        class="btn btn-primary mb-2">
                    <i class="fas fa-save"></i> Update & Save
                </button>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="<?php echo e(asset('backend-asset/plugins/tinymce/tinymce.min.js')); ?>"></script>
<script>
$(document).ready(function () {
    if (typeof tinymce !== 'undefined') {
        $('textarea.tinymce-editor').each(function (index) {
            if (!this.id) {
                this.id = 'tinymce_editor_' + index;
            }
        });

        tinymce.init({
            selector: 'textarea.tinymce-editor',
            license_key: 'gpl',
            height: 320,
            menubar: true,
            branding: false,
            promotion: false,
            convert_urls: false,
            relative_urls: false,
            remove_script_host: false,
            plugins: 'preview searchreplace autolink autosave directionality visualblocks visualchars fullscreen image link media table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help code emoticons',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | blockquote code preview fullscreen | removeformat',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            setup: function (editor) {
                editor.on('change keyup setcontent', function () {
                    editor.save();
                });
            }
        });
    }

    const locale = <?php echo json_encode($code, 15, 512) ?>;

    function updateCharCount(inputSelector, counterSelector) {
        const value = $(inputSelector).val() || '';
        $(counterSelector).text(value.length);
    }

    updateCharCount('#meta_title_' + locale, '#meta_title_count_' + locale);
    updateCharCount('#meta_description_' + locale, '#meta_description_count_' + locale);

    $(document).on('input', '#meta_title_' + locale, function () {
        updateCharCount('#meta_title_' + locale, '#meta_title_count_' + locale);
    });

    $(document).on('input', '#meta_description_' + locale, function () {
        updateCharCount('#meta_description_' + locale, '#meta_description_count_' + locale);
    });

    $('#previewBtn').on('click', function (e) {
        e.preventDefault();

        if (typeof tinymce !== 'undefined') {
            tinymce.triggerSave();
        }

        const form = document.getElementById('miniCampaignForm');
        const originalAction = form.getAttribute('action');
        const originalTarget = form.getAttribute('target');

        const methodInput = form.querySelector('input[name="_method"]');
        let methodDisabled = false;

        if (methodInput) {
            methodInput.disabled = true;
            methodDisabled = true;
        }

        form.setAttribute('target', '_blank');
        form.setAttribute('action', "<?php echo e(route('campaigns.miniCampaignPreview.store')); ?>");
        form.submit();

        setTimeout(function () {
            form.setAttribute('action', originalAction);

            if (originalTarget) {
                form.setAttribute('target', originalTarget);
            } else {
                form.removeAttribute('target');
            }

            if (methodInput && methodDisabled) {
                methodInput.disabled = false;
            }
        }, 700);
    });

    $('#miniCampaignForm').on('submit', function (e) {
        const isPreviewSubmit = $(this).attr('target') === '_blank';

        if (typeof tinymce !== 'undefined') {
            tinymce.triggerSave();
        }

        if (!isPreviewSubmit) {
            $('#realSubmitBtn')
                .prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin"></i> Updating...');
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/saingo/public_html/resources/views/admin/canpaign/mini_campaign_edit.blade.php ENDPATH**/ ?>