<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use File;

class Media extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filename', 'uri',
        'size', 'mime_type',
        'alt', 'caption',
        'created_at', 'updated_at'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'url', 'thumbnail',
    ];

    /**
     * Get the storage URL.
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->uri);
    }

    /**
     * Get the thumbnail's storage URL.
     */
    public function getThumbnailAttribute()
    {
        return $this->getFormat('sd');
    }

    /**
     * Get the formatted size.
     */
    public function getSizeAttribute($size)
    {
        if ($size >= 1000000) {
            return round($size / 1000000, 1) . ' MB';
        } elseif ($size >= 1000) {
            return round($size / 1000, 1) . ' KB';
        }

        return $size . ' B';
    }

    /**
     * Get the file's extension.
     *
     * @return string
     */
    public function getExtension()
    {
        return File::extension($this->filename);
    }

    /**
     * Get the file's path.
     *
     * @return string
     */
    public function getPath()
    {
        return Storage::path($this->uri);
    }

    /**
     * Get the file's URI for a given format.
     *
     * @param  string $format
     * @return string
     */
    public function getUriFromFormat($format)
    {
        $extension = $this->getExtension();
        $uri = str_replace('.'. $extension, '_'. $format .'.'. $extension, $this->uri);

        return $uri;
    }

    /**
     * Get the file's URL for a given format.
     *
     * @param  string $format
     * @return string
     */
    public function getFormat($format)
    {
        if ($this->isImage()) {
            $uri = $this->getUriFromFormat($format);

            return Storage::exists($uri) ? Storage::url($uri) : null;
        }

        return null;
    }

    /**
     * Check if the file is an image.
     *
     * @return boolean
     */
    public function isImage()
    {
        return preg_match('/^image/', $this->mime_type);
    }

    /**
     * Generate thumbnails
     *
     * @param  array  $formats
     * @return void
     */
    public function generateThumbnails($formats = [])
    {
        if (! $this->isImage()) {
            return false;
        }

        $file = Storage::get($this->uri);
        $extension = $this->getExtension();

        if (Storage::exists($this->uri)) {
            // Don't resize gifs so we don't lose animations
            // Intervention/Image does not support resizing animated gifs
            if ($extension !== 'gif') {
                // Resize up to 2560x2560
                if (empty($formats) || in_array('full', $formats)) {
                    try {
                        $imageFull = Image::make($file);
                    } catch (\Exception $e) {
                        return $e->getMessage();
                    }

                    if ($imageFull->width() > 2560 || $imageFull->height() > 2560) {
                        $imageFull->resize(2560, 2560, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                        $imageFull->interlace();
                        $imageFull->encode($extension);

                        Storage::put($this->uri, $imageFull->stream(), 'public');

                        $imageFull->destroy();

                        $this->update(['size' => Storage::size($this->uri)]);
                    }
                }
            }

            // Create HD version
            if (empty($formats) || in_array('hd', $formats)) {
                $uri = str_replace(".{$extension}", "_hd.$extension", $this->uri);

                try {
                    $imageHD = Image::make($file);
                } catch (\Exception $e) {
                    return $e->getMessage();
                }

                $imageHD->resize(1920, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $imageHD->interlace();
                $imageHD->encode($extension);

                Storage::put($uri, $imageHD->stream(), 'public');

                $imageHD->destroy();
            }

            // Create SD version
            if (empty($formats) || in_array('sd', $formats)) {
                $uri = str_replace(".{$extension}", "_sd.$extension", $this->uri);

                try {
                    $imageSD = Image::make($file);
                } catch (\Exception $e) {
                    return $e->getMessage();
                }

                $imageSD->resize(960, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $imageSD->interlace();
                $imageSD->encode($extension);

                Storage::put($uri, $imageSD->stream(), 'public');

                $imageSD->destroy();
            }
        }
    }
}
