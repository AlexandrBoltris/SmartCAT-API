<?php

namespace SmartCAT\API\Normalizer;

use Joli\Jane\Runtime\Reference;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;
class DocumentWorkflowStageModelNormalizer extends SerializerAwareNormalizer implements DenormalizerInterface, NormalizerInterface
{
    public function supportsDenormalization($data, $type, $format = null)
    {
        if ($type !== 'SmartCAT\\API\\Model\\DocumentWorkflowStageModel') {
            return false;
        }
        return true;
    }
    public function supportsNormalization($data, $format = null)
    {
        if ($data instanceof \SmartCAT\API\Model\DocumentWorkflowStageModel) {
            return true;
        }
        return false;
    }
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $object = new \SmartCAT\API\Model\DocumentWorkflowStageModel();
        if (property_exists($data, 'progress')) {
            $object->setProgress($data->{'progress'});
        }
        if (property_exists($data, 'wordsTranslated')) {
            $object->setWordsTranslated($data->{'wordsTranslated'});
        }
        if (property_exists($data, 'unassignedWordsCount')) {
            $object->setUnassignedWordsCount($data->{'unassignedWordsCount'});
        }
        if (property_exists($data, 'status')) {
            $object->setStatus($data->{'status'});
        }
        if (property_exists($data, 'executives')) {
            $values = array();
            foreach ($data->{'executives'} as $value) {
                $values[] = $this->serializer->deserialize($value, 'SmartCAT\\API\\Model\\AssignedExecutiveModel', 'raw', $context);
            }
            $object->setExecutives($values);
        }
        return $object;
    }
    public function normalize($object, $format = null, array $context = array())
    {
        $data = new \stdClass();
        if (null !== $object->getProgress()) {
            $data->{'progress'} = $object->getProgress();
        }
        if (null !== $object->getWordsTranslated()) {
            $data->{'wordsTranslated'} = $object->getWordsTranslated();
        }
        if (null !== $object->getUnassignedWordsCount()) {
            $data->{'unassignedWordsCount'} = $object->getUnassignedWordsCount();
        }
        if (null !== $object->getStatus()) {
            $data->{'status'} = $object->getStatus();
        }
        if (null !== $object->getExecutives()) {
            $values = array();
            foreach ($object->getExecutives() as $value) {
                $values[] = $this->serializer->serialize($value, 'raw', $context);
            }
            $data->{'executives'} = $values;
        }
        return $data;
    }
}